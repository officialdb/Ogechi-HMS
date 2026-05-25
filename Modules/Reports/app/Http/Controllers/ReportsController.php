<?php

namespace Modules\Reports\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
    {
        // 1. Key Performance Indicators (KPIs)
        $totalPatients = \Modules\Patients\Models\Patient::count();
        $totalRevenue = \Modules\Billing\Models\Invoice::where('status', 'paid')->sum('total_amount');
        $pendingRevenue = \Modules\Billing\Models\Invoice::where('status', 'pending')->sum('total_amount');
        
        $completedAppointments = \Modules\Appointments\Models\Appointment::where('status', 'completed')->count();
        $totalAppointments = \Modules\Appointments\Models\Appointment::count();
        $completionRate = $totalAppointments > 0 ? round(($completedAppointments / $totalAppointments) * 100) : 0;

        // 2. Revenue over the last 6 months (Line Chart)
        $revenueData = [];
        $revenueLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->startOfMonth()->subMonths($i);
            $revenueLabels[] = $month->format('M Y');
            
            $sum = \Modules\Billing\Models\Invoice::where('status', 'paid')
                ->whereYear('issue_date', $month->year)
                ->whereMonth('issue_date', $month->month)
                ->sum('total_amount');
                
            $revenueData[] = (float) $sum;
        }

        // 3. Appointment Status Breakdown (Doughnut Chart)
        $aptStatuses = DB::table('appointments')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
            
        $aptStatusLabels = [];
        $aptStatusData = [];
        $aptStatusColors = [];
        
        $colorMap = [
            'pending' => '#f59e0b',
            'confirmed' => '#3b82f6',
            'completed' => '#10b981',
            'cancelled' => '#ef4444'
        ];
        
        foreach ($aptStatuses as $status) {
            $aptStatusLabels[] = ucfirst($status->status);
            $aptStatusData[] = $status->total;
            $aptStatusColors[] = $colorMap[$status->status] ?? '#94a3b8';
        }

        // 4. Patient Registrations over last 6 months (Bar Chart)
        $patientRegData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->startOfMonth()->subMonths($i);
            
            $count = \Modules\Patients\Models\Patient::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
                
            $patientRegData[] = $count;
        }

        return view('reports::index', compact(
            'totalPatients', 'totalRevenue', 'pendingRevenue', 'completionRate',
            'revenueLabels', 'revenueData',
            'aptStatusLabels', 'aptStatusData', 'aptStatusColors',
            'patientRegData'
        ));
    }
}
