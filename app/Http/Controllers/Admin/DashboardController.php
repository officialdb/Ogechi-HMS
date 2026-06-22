<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __invoke(): View|\Illuminate\Http\Response
    {
        if (auth()->user()->hasRole('Doctor')) {
            return app(\App\Http\Controllers\DoctorDashboardController::class)();
        }
        // ── KPI Headline Numbers ─────────────────────────────────────────
        $totalPatients     = $this->countTable('patients');
        $totalDoctors      = $this->countTable('doctors');
        $totalDepartments  = $this->countTable('departments');
        $totalMedications  = $this->countTable('medications');

        // ── Appointments ─────────────────────────────────────────────────
        $todayAppointments = Schema::hasTable('appointments')
            ? DB::table('appointments')->whereDate('appointment_date', today())->count()
            : 0;

        $pendingAppointments = Schema::hasTable('appointments') 
            ? DB::table('appointments')->where('status', 'pending')->count()
            : 0;

        // ── Revenue ──────────────────────────────────────────────────────
        if (!Schema::hasTable('invoices')) {
            $revenueData = ['total' => 0, 'month' => 0, 'last_month' => 0];
        } else {
            $invoices = DB::table('invoices')->where('status', 'paid')->get(['total_amount', 'issue_date']);
            $total = (float) $invoices->sum('total_amount');
            $month = (float) $invoices->filter(fn($i) => Carbon::parse($i->issue_date)->isCurrentMonth())->sum('total_amount');
            $lastMonth = (float) $invoices->filter(fn($i) => Carbon::parse($i->issue_date)->isLastMonth())->sum('total_amount');
            $revenueData = ['total' => $total, 'month' => $month, 'last_month' => $lastMonth];
        }

        $totalRevenue = $revenueData['total'];
        $monthRevenue = $revenueData['month'];
        $revenueGrowth = $revenueData['last_month'] > 0
            ? round((($monthRevenue - $revenueData['last_month']) / $revenueData['last_month']) * 100, 1)
            : 0;

        // ── Recent Patients ──────────────────────────────────────────────
        $recentPatients = Schema::hasTable('patients')
            ? DB::table('patients')
                ->select('id', 'uuid', 'first_name', 'last_name', 'patient_number', 'gender', 'created_at')
                ->latest()
                ->limit(6)
                ->get()
            : collect();

        // ── Upcoming Appointments ────────────────────────────────────────
        $upcomingAppointments = Schema::hasTable('appointments')
            ? DB::table('appointments')
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
            : collect();

        // ── Low Stock Medications ────────────────────────────────────────
        $lowStockMeds = Schema::hasTable('medications')
            ? DB::table('medications')
                ->whereIn('status', ['low_stock', 'out_of_stock'])
                ->select('id', 'name', 'quantity_in_stock', 'status')
                ->orderBy('quantity_in_stock')
                ->limit(5)
                ->get()
            : collect();

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
