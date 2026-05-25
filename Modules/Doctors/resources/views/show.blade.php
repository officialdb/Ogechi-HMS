<x-admin-layout title="Doctor Profile – {{ $doctor->full_name }}">
<div class="space-y-6">

    {{-- ── BREADCRUMB ─────────────────────────────────── --}}
    <div class="flex items-center gap-2 flex-wrap">
        <a href="{{ route('dashboard') }}" class="text-xs text-slate-400 hover:text-blue-600 transition-colors">Dashboard</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('modules.doctors.index') }}" class="text-xs text-slate-400 hover:text-blue-600 transition-colors">Doctors</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="text-xs text-blue-600 font-semibold truncate max-w-[160px]">{{ $doctor->full_name }}</span>
    </div>

    {{-- ── DOCTOR HEADER CARD ─────────────────────────── --}}
    @php
        $initials = strtoupper(substr($doctor->first_name,0,1).substr($doctor->last_name,0,1));
        $gradients = ['from-blue-500 to-blue-700','from-violet-500 to-purple-700','from-emerald-500 to-teal-700'];
        $grad = $gradients[$doctor->id % 3];
    @endphp

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        {{-- Cover banner --}}
        <div class="h-24 bg-gradient-to-br {{ $grad }} relative">
            <div class="absolute inset-0 opacity-20" style="background-image:radial-gradient(circle at 20% 50%,rgba(255,255,255,0.4) 0%,transparent 60%);"></div>
        </div>

        <div class="px-6 pb-6">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 -mt-8">
                {{-- Avatar --}}
                <div class="flex items-end gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br {{ $grad }} text-white font-black text-xl flex items-center justify-center shadow-xl border-4 border-white flex-shrink-0">
                        {{ $initials }}
                    </div>
                    <div class="mb-1">
                        <h1 class="text-lg font-black text-slate-900 leading-none">{{ $doctor->full_name }}</h1>
                        <p class="text-xs text-slate-500 mt-1">{{ $doctor->specialization }}</p>
                    </div>
                </div>
                {{-- Actions --}}
                <div class="flex items-center gap-2 mt-2 sm:mt-0 sm:mb-1">
                    <a href="{{ route('modules.doctors.edit', $doctor) }}"
                       class="flex items-center gap-1.5 px-4 py-2 text-sm font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90"
                       style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit Profile
                    </a>
                    <a href="{{ route('modules.doctors.index') }}"
                       class="flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Back
                    </a>
                </div>
            </div>

            {{-- Badges row --}}
            <div class="flex items-center flex-wrap gap-2 mt-4 pt-4 border-t border-slate-100">
                @if($doctor->status === 'active')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                    </span>
                @elseif($doctor->status === 'on_leave')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold bg-amber-50 text-amber-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> On Leave
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-600">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Inactive
                    </span>
                @endif
                <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-lg text-xs font-bold font-mono">
                    LIC: {{ $doctor->license_number }}
                </span>
                <span class="px-3 py-1 bg-slate-50 text-slate-500 rounded-lg text-xs font-semibold">
                    Joined {{ $doctor->created_at->format('M d, Y') }}
                </span>
            </div>
        </div>
    </div>

    {{-- ── MAIN GRID ─────────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: Contact & Quick Info --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <h2 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <div class="w-7 h-7 bg-violet-50 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    Contact Details
                </h2>
                <dl class="space-y-3">
                    <div class="flex items-start justify-between gap-2 pb-3 border-b border-slate-50">
                        <dt class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Email</dt>
                        <dd class="text-xs font-bold text-slate-700 text-right">{{ $doctor->email ?? 'Not provided' }}</dd>
                    </div>
                    <div class="flex items-start justify-between gap-2">
                        <dt class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Phone</dt>
                        <dd class="text-xs font-bold text-slate-700 text-right">{{ $doctor->phone }}</dd>
                    </div>
                </dl>
            </div>
            
            <div class="bg-blue-50/50 rounded-2xl border border-blue-100/50 p-5 flex items-center justify-between">
                <div>
                    <h3 class="text-xs font-bold text-slate-800">Total Appointments</h3>
                    <p class="text-[10px] text-slate-500 mt-0.5">Assigned this month</p>
                </div>
                <div class="text-2xl font-black text-blue-600">0</div>
            </div>
        </div>

        {{-- Right: Bio & Professional details --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h2 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <div class="w-7 h-7 bg-amber-50 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    Biography & Professional Notes
                </h2>
                @if($doctor->bio)
                    <div class="prose prose-sm text-slate-600 max-w-none">
                        {!! nl2br(e($doctor->bio)) !!}
                    </div>
                @else
                    <p class="text-sm text-slate-400 italic">No biography or professional notes provided for this doctor.</p>
                @endif
            </div>

            {{-- Coming Soon: Schedule/Appointments Block --}}
            <div class="bg-white rounded-2xl border border-slate-100 border-dashed shadow-sm p-8 text-center">
                <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center mx-auto mb-3 border border-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-slate-800 mb-1">Appointment Schedule</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">This section will display the doctor's upcoming appointments and shift schedules once the Appointments module is integrated.</p>
            </div>
        </div>

    </div>

</div>
</x-admin-layout>
