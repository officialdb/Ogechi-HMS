<x-admin-layout title="Reports & Analytics">
<div class="space-y-6">
    
    {{-- ── HEADER ─────────────────────────────────────── --}}
    <div class="print:hidden flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Reports & Analytics</h1>
            <p class="text-sm text-slate-500 mt-1">Hospital performance, revenue, and demographic insights.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                <x-fas-chart-bar class="w-5 h-5" />
                Print Report
            </button>
        </div>
    </div>
    
    <div class="hidden print:block mb-8 border-b-2 border-slate-800 pb-4">
        <h1 class="text-3xl font-black text-black tracking-tight">Ogechi Hospital - Performance Report</h1>
        <p class="text-slate-600 font-bold">Generated on: {{ \Carbon\Carbon::now()->format('F d, Y \a\t h:i A') }}</p>
    </div>

    {{-- ── KPI CARDS ──────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm relative overflow-hidden group print:border-slate-300">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <x-fas-user-injured class="w-16 h-16 text-blue-600" />
            </div>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 relative z-10">Total Patients</p>
            <p class="text-3xl font-black text-slate-900 relative z-10">{{ number_format($totalPatients) }}</p>
        </div>
        
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm relative overflow-hidden group print:border-slate-300">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <x-fas-chart-bar class="w-16 h-16 text-emerald-600" />
            </div>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 relative z-10">Collected Revenue</p>
            <p class="text-3xl font-black text-emerald-600 relative z-10">{{ $currency_symbol }}{{ number_format($totalRevenue, 2) }}</p>
        </div>

        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm relative overflow-hidden group print:border-slate-300">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <x-fas-chart-bar class="w-16 h-16 text-amber-600" />
            </div>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 relative z-10">Pending Revenue</p>
            <p class="text-3xl font-black text-amber-600 relative z-10">{{ $currency_symbol }}{{ number_format($pendingRevenue, 2) }}</p>
        </div>
        
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm relative overflow-hidden group print:border-slate-300">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <x-fas-user-injured class="w-16 h-16 text-indigo-600" />
            </div>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 relative z-10">Apt. Completion Rate</p>
            <p class="text-3xl font-black text-indigo-600 relative z-10">{{ $completionRate }}%</p>
        </div>
    </div>

    {{-- ── CHARTS ROW 1 ───────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Revenue Chart --}}
        <div class="lg:col-span-2 bg-white border border-slate-100 rounded-2xl p-6 shadow-sm print:border-slate-300">
            <h3 class="text-sm font-bold text-slate-800 mb-6">Revenue Trend (Last 6 Months)</h3>
            <div class="relative h-72 w-full">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        {{-- Appointment Breakdown Chart --}}
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm print:border-slate-300">
            <h3 class="text-sm font-bold text-slate-800 mb-6">Appointment Statuses</h3>
            <div class="relative h-64 w-full flex items-center justify-center">
                @if(array_sum($aptStatusData) > 0)
                    <canvas id="appointmentChart"></canvas>
                @else
                    <p class="text-sm text-slate-400 font-semibold">No appointments recorded yet.</p>
                @endif
            </div>
        </div>

    </div>

    {{-- ── CHARTS ROW 2 ───────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- Patient Registrations Chart --}}
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm print:border-slate-300">
            <h3 class="text-sm font-bold text-slate-800 mb-6">Patient Registrations (Last 6 Months)</h3>
            <div class="relative h-72 w-full">
                <canvas id="patientsChart"></canvas>
            </div>
        </div>

        {{-- Empty Placeholder for future chart --}}
        <div class="bg-slate-50 border border-slate-100 border-dashed rounded-2xl p-6 flex flex-col items-center justify-center text-center print:hidden">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm border border-slate-100">
                <x-fas-chart-bar class="w-6 h-6 text-slate-300" />
            </div>
            <p class="text-sm font-bold text-slate-700">Custom Widget Space</p>
            <p class="text-xs text-slate-500 mt-1 max-w-xs">Additional charts like Pharmacy Top Sellers or Doctor Performance can be added here.</p>
        </div>

    </div>

</div>

{{-- Chart.js Script Integration --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // Common Chart Defaults for Premium Look
        Chart.defaults.font.family = "'Inter', 'sans-serif'";
        Chart.defaults.color = '#64748b'; // slate-500
        Chart.defaults.plugins.tooltip.backgroundColor = 'rgba(15, 23, 42, 0.9)'; // slate-900
        Chart.defaults.plugins.tooltip.padding = 12;
        Chart.defaults.plugins.tooltip.cornerRadius = 8;
        Chart.defaults.plugins.tooltip.titleFont = { size: 14, weight: 'bold' };
        Chart.defaults.plugins.tooltip.bodyFont = { size: 13 };

        // 1. Revenue Line Chart
        const revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx) {
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: @json($revenueLabels),
                    datasets: [{
                        label: 'Collected Revenue ($)',
                        data: @json($revenueData),
                        borderColor: '#2563eb', // blue-600
                        backgroundColor: 'rgba(37, 99, 235, 0.1)', // blue-600 w/ opacity
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#2563eb',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4 // Smooth curves
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { color: '#f1f5f9', drawBorder: false }, // slate-100
                            ticks: { callback: function(value) { return '$' + value; } }
                        },
                        x: { grid: { display: false, drawBorder: false } }
                    },
                    interaction: { mode: 'index', intersect: false }
                }
            });
        }

        // 2. Appointment Doughnut Chart
        const aptCtx = document.getElementById('appointmentChart');
        if (aptCtx) {
            new Chart(aptCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($aptStatusLabels),
                    datasets: [{
                        data: @json($aptStatusData),
                        backgroundColor: @json($aptStatusColors),
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%', // Thin doughnut
                    plugins: {
                        legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: { weight: 'bold' } } }
                    }
                }
            });
        }

        // 3. Patient Registrations Bar Chart
        const patientsCtx = document.getElementById('patientsChart');
        if (patientsCtx) {
            new Chart(patientsCtx, {
                type: 'bar',
                data: {
                    labels: @json($revenueLabels), // Reusing same month labels
                    datasets: [{
                        label: 'New Patients',
                        data: @json($patientRegData),
                        backgroundColor: '#8b5cf6', // violet-500
                        borderRadius: 6, // Rounded bars
                        borderSkipped: false,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#f1f5f9', drawBorder: false }, ticks: { precision: 0 } },
                        x: { grid: { display: false, drawBorder: false } }
                    }
                }
            });
        }
    });
</script>
</x-admin-layout>
