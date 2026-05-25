<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        // ── KPI Headline Numbers ─────────────────────────────────────────
        $totalPatients     = Cache::remember('total_patients', 3600, fn() => $this->countTable('patients'));
        $totalDoctors      = Cache::remember('total_doctors', 3600, fn() => $this->countTable('doctors'));
        $totalDepartments  = Cache::remember('total_departments', 3600, fn() => $this->countTable('departments'));
        $totalMedications  = Cache::remember('total_medications', 3600, fn() => $this->countTable('medications'));

        // ── Appointments ─────────────────────────────────────────────────
        $todayAppointments = Cache::remember('today_appointments', 600, function () {
            return Schema::hasTable('appointments')
                ? DB::table('appointments')->whereDate('appointment_date', today())->count()
                : 0;
        });

        $pendingAppointments = Cache::remember('pending_appointments', 600, function () {
            return DB::table('appointments')->where('status', 'pending')->count();
        });

        // ── Revenue ──────────────────────────────────────────────────────
        $revenueData = Cache::remember('revenue_data', 3600, function () {
            if (!Schema::hasTable('invoices')) {
                return ['total' => 0, 'month' => 0, 'last_month' => 0];
            }

            $invoices = DB::table('invoices')->where('status', 'paid')->get(['total_amount', 'issue_date']);

            $total = (float) $invoices->sum('total_amount');
            $month = (float) $invoices->filter(fn($i) => Carbon::parse($i->issue_date)->isCurrentMonth())->sum('total_amount');
            $lastMonth = (float) $invoices->filter(fn($i) => Carbon::parse($i->issue_date)->isLastMonth())->sum('total_amount');

            return ['total' => $total, 'month' => $month, 'last_month' => $lastMonth];
        });

        $totalRevenue = $revenueData['total'];
        $monthRevenue = $revenueData['month'];
        $revenueGrowth = $revenueData['last_month'] > 0
            ? round((($monthRevenue - $revenueData['last_month']) / $revenueData['last_month']) * 100, 1)
            : 0;

        // ── Recent Patients ──────────────────────────────────────────────
        $recentPatientsArray = Cache::remember('recent_patients', 600, function () {
            return Schema::hasTable('patients')
                ? DB::table('patients')
                    ->select('id', 'first_name', 'last_name', 'patient_number', 'gender', 'created_at')
                    ->latest()
                    ->limit(6)
                    ->get()
                    ->map(fn($item) => (array) $item)
                    ->toArray()
                : [];
        });
        $recentPatients = collect($recentPatientsArray)->map(fn($item) => (object) $item);

        // ── Upcoming Appointments ────────────────────────────────────────
        $upcomingAppointmentsArray = Cache::remember('upcoming_appointments', 600, function () {
            return DB::table('appointments')
                ->join('patients', 'appointments.patient_id', '=', 'patients.id')
                ->join('doctors',  'appointments.doctor_id',  '=', 'doctors.id')
                ->select(
                    'appointments.id',
                    'appointments.appointment_date',
                    'appointments.appointment_time',
                    'appointments.status',
                    'appointments.reason',
                    'patients.first_name as patient_first',
                    'patients.last_name  as patient_last',
                    'doctors.first_name  as doctor_first',
                    'doctors.last_name   as doctor_last',
                    'doctors.specialization'
                )
                ->where('appointments.appointment_date', '>=', today())
                ->whereIn('appointments.status', ['pending', 'confirmed'])
                ->orderBy('appointments.appointment_date')
                ->orderBy('appointments.appointment_time')
                ->limit(6)
                ->get()
                ->map(fn($item) => (array) $item)
                ->toArray();
        });
        $upcomingAppointments = collect($upcomingAppointmentsArray)->map(fn($item) => (object) $item);

        // ── Low Stock Medications ────────────────────────────────────────
        $lowStockMedsArray = Cache::remember('low_stock_meds', 1800, function () {
            return Schema::hasTable('medications')
                ? DB::table('medications')
                    ->whereIn('status', ['low_stock', 'out_of_stock'])
                    ->select('id', 'name', 'quantity_in_stock', 'status')
                    ->orderBy('quantity_in_stock')
                    ->limit(5)
                    ->get()
                    ->map(fn($item) => (array) $item)
                    ->toArray()
                : [];
        });
        $lowStockMeds = collect($lowStockMedsArray)->map(fn($item) => (object) $item);

        // ── Appointment Status Breakdown ─────────────────────────────────
        $aptStatusCounts = Schema::hasTable('appointments')
            ? DB::table('appointments')
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status')
            : collect();

        // ── Monthly Revenue Chart (last 6 months) ────────────────────────
        $revenueChart = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->startOfMonth()->subMonths($i);
            $revenueChart[] = [
                'label' => $month->format('M'),
                'value' => Schema::hasTable('invoices')
                    ? (float) DB::table('invoices')
                        ->where('status', 'paid')
                        ->whereYear('issue_date', $month->year)
                        ->whereMonth('issue_date', $month->month)
                        ->sum('total_amount')
                    : 0,
            ];
        }

        return view('admin.dashboard', compact(
            'totalPatients', 'totalDoctors', 'totalDepartments', 'totalMedications',
            'todayAppointments', 'pendingAppointments',
            'totalRevenue', 'monthRevenue', 'revenueGrowth',
            'recentPatients', 'upcomingAppointments', 'lowStockMeds',
            'aptStatusCounts', 'revenueChart'
        ));
    }

    private function countTable(string $table): int
    {
        return Schema::hasTable($table) ? DB::table($table)->count() : 0;
    }
}
