<x-admin-layout title="Doctor Dashboard">
    <div class="space-y-6">

        {{-- Welcome Header --}}
        <div class="flex items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center shadow-md flex-shrink-0" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Welcome, {{ $doctor->full_name }}</h1>
                <p class="text-sm text-slate-500 mt-0.5">{{ $doctor->specialization }} {{ $doctor->department ? ' • ' . $doctor->department->name : '' }}</p>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Appointments Today</p>
                    <p class="text-2xl font-black text-slate-800">{{ $todayAppointments }}</p>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Patients</p>
                    <p class="text-2xl font-black text-slate-800">{{ $totalPatients }}</p>
                </div>
            </div>
        </div>

        {{-- Upcoming Appointments --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-bold text-slate-800">Your Upcoming Appointments</h2>
                <a href="{{ route('modules.appointments.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800">View All</a>
            </div>
            @if($upcomingAppointments->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-500 font-semibold text-xs tracking-wide uppercase">
                                <th class="px-6 py-3">Patient</th>
                                <th class="px-6 py-3">Date & Time</th>
                                <th class="px-6 py-3">Reason</th>
                                <th class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-slate-700">
                            @foreach($upcomingAppointments as $apt)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-3.5 font-bold">{{ $apt->patient->first_name ?? 'N/A' }} {{ $apt->patient->last_name ?? '' }}</td>
                                    <td class="px-6 py-3.5">
                                        <div class="text-xs font-bold text-slate-800">{{ \Carbon\Carbon::parse($apt->appointment_date)->format('M d, Y') }}</div>
                                        <div class="text-[11px] text-slate-500">{{ \Carbon\Carbon::parse($apt->appointment_time)->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-3.5 text-xs text-slate-500 truncate max-w-[200px]">{{ $apt->reason ?? 'No reason provided' }}</td>
                                    <td class="px-6 py-3.5">
                                        @if($apt->status === 'confirmed')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-700">Confirmed</span>
                                        @elseif($apt->status === 'pending')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-700">Pending</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700">{{ ucfirst($apt->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-12 text-center text-slate-500 text-sm">
                    No upcoming appointments scheduled.
                </div>
            @endif
        </div>

    </div>
</x-admin-layout>
