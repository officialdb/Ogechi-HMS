<x-admin-layout title="Appointments">
<div class="space-y-6">
    
    {{-- ── HEADER ─────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Appointments</h1>
            <p class="text-sm text-slate-500 mt-1">Manage patient bookings and hospital schedules</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- View Toggles --}}
            <div class="bg-slate-100 p-1 rounded-xl flex items-center border border-slate-200">
                <a href="{{ route('modules.appointments.index') }}" class="px-3 py-1.5 text-xs font-bold rounded-lg bg-white text-blue-600 shadow-sm transition-colors">
                    List
                </a>
                <a href="{{ route('modules.appointments.index', ['view' => 'calendar']) }}" class="px-3 py-1.5 text-xs font-semibold rounded-lg text-slate-500 hover:text-slate-700 transition-colors">
                    Calendar
                </a>
            </div>

            <a href="{{ route('modules.appointments.create') }}" class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                <x-fas-calendar-alt class="w-5 h-5" />
                Schedule Appointment
            </a>
        </div>
    </div>

    {{-- ── FILTER / SEARCH BAR ────────────────────────── --}}
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col sm:flex-row gap-4 items-center justify-between">
        <form method="GET" action="{{ route('modules.appointments.index') }}" class="flex-1 w-full sm:w-auto relative" id="search-form">
            <x-fas-plus class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Search by patient name, patient number, or doctor name…" 
                   class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
        </form>
        <div class="flex items-center gap-2 w-full sm:w-auto overflow-x-auto pb-1 sm:pb-0 hide-scrollbar">
            @foreach(['all'=>'All','pending'=>'Pending','confirmed'=>'Confirmed','completed'=>'Completed','cancelled'=>'Cancelled'] as $val => $label)
                @php $isActive = request('status', 'all') === $val; @endphp
                <a href="{{ request()->fullUrlWithQuery(['status' => $val, 'page' => 1]) }}" 
                   class="whitespace-nowrap px-4 py-2 text-xs font-bold rounded-xl transition-colors border {{ $isActive ? 'bg-blue-50 text-blue-700 border-blue-200' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- ── DATA GRID ──────────────────────────────────── --}}
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden relative">
        
        {{-- Skeleton overlay --}}
        <div x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 800)">
            <div x-show="loading" x-transition.opacity class="absolute inset-0 bg-white z-10 p-5">
                <div class="space-y-4">
                    <div class="skeleton h-10 w-full rounded-xl"></div>
                    @for($i=0; $i<5; $i++)
                        <div class="skeleton h-16 w-full rounded-xl"></div>
                    @endfor
                </div>
            </div>
            
            @if($appointments->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-500 font-semibold text-xs tracking-wide uppercase">
                                <th class="px-6 py-4">Patient</th>
                                <th class="px-6 py-4">Doctor / Dept</th>
                                <th class="px-6 py-4">Date & Time</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-slate-700">
                            @foreach($appointments as $apt)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-6 py-3.5">
                                        <div class="flex items-center gap-3">
                                            @php
                                                $initials = strtoupper(substr($apt->patient->first_name,0,1).substr($apt->patient->last_name,0,1));
                                            @endphp
                                            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 font-bold flex items-center justify-center flex-shrink-0 border border-slate-200 shadow-sm">
                                                {{ $initials }}
                                            </div>
                                            <div>
                                                <a href="{{ route('patients.show', $apt->patient->uuid) }}" class="font-bold text-slate-900 group-hover:text-blue-600 transition-colors">{{ $apt->patient->full_name }}</a>
                                                <p class="text-[11px] text-slate-500 mt-0.5 font-mono">{{ $apt->patient->patient_number }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3.5">
                                        <p class="font-bold text-slate-700">{{ $apt->doctor->full_name }}</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5">{{ $apt->doctor->specialization }}</p>
                                    </td>
                                    <td class="px-6 py-3.5">
                                        <p class="font-bold text-slate-700">{{ $apt->appointment_date->format('M d, Y') }}</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5 font-medium flex items-center gap-1">
                                            <x-fas-chart-bar class="w-3 h-3 text-slate-400" />
                                            {{ \Carbon\Carbon::parse($apt->appointment_time)->format('h:i A') }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-3.5">
                                        @if($apt->status === 'confirmed')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100/50">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Confirmed
                                            </span>
                                        @elseif($apt->status === 'completed')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100/50">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Completed
                                            </span>
                                        @elseif($apt->status === 'pending')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100/50">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200/50">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Cancelled
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3.5 text-right">
                                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('modules.appointments.show', $apt) }}" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors" title="View Details">
                                                <x-fas-eye class="w-4 h-4" />
                                            </a>
                                            <a href="{{ route('modules.appointments.edit', $apt) }}" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center hover:bg-slate-200 transition-colors" title="Reschedule / Edit">
                                                <x-fas-tachometer-alt class="w-4 h-4" />
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                @if($appointments->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $appointments->links() }}
                    </div>
                @endif
            @else
                <div class="py-16 px-6 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-100">
                        <x-fas-tachometer-alt class="w-8 h-8 text-slate-300" />
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 mb-1">No Appointments Found</h3>
                    <p class="text-xs text-slate-500 mb-4 max-w-sm mx-auto">There are no appointments matching your search criteria. Schedule a new appointment to get started.</p>
                    <a href="{{ route('modules.appointments.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                        Schedule Appointment
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
</x-admin-layout>
