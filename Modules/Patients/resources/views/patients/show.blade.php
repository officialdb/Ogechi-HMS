<x-admin-layout title="Patient – {{ $patient->full_name }}">
<div class="space-y-5">

    {{-- ── BREADCRUMB ─────────────────────────────────── --}}
    <div class="flex items-center gap-2 flex-wrap">
        <a href="{{ route('dashboard') }}" class="text-xs text-slate-400 hover:text-blue-600 transition-colors">Dashboard</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('patients.index') }}" class="text-xs text-slate-400 hover:text-blue-600 transition-colors">Patients</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="text-xs text-blue-600 font-semibold truncate max-w-[160px]">{{ $patient->full_name }}</span>
    </div>

    {{-- ── PATIENT HEADER CARD ─────────────────────────── --}}
    @php
        $initials = strtoupper(substr($patient->first_name,0,1).substr($patient->last_name,0,1));
        $gradients = ['from-blue-500 to-blue-700','from-violet-500 to-purple-700','from-rose-500 to-rose-700','from-emerald-500 to-teal-700','from-amber-500 to-orange-600'];
        $grad = $gradients[$patient->id % 5];
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
                        <h1 class="text-lg font-black text-slate-900 leading-none">{{ $patient->full_name }}</h1>
                        <p class="text-xs text-slate-500 mt-1 capitalize">{{ $patient->gender }} · {{ $patient->date_of_birth?->age ?? '—' }} years old</p>
                    </div>
                </div>
                {{-- Actions --}}
                <div class="flex items-center gap-2 mt-2 sm:mt-0 sm:mb-1">
                    @can('patients.update')
                        <a href="{{ route('patients.edit', $patient) }}"
                           class="flex items-center gap-1.5 px-4 py-2 text-sm font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90"
                           style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit Patient
                        </a>
                    @endcan
                    <a href="{{ route('patients.index') }}"
                       class="flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Back
                    </a>
                </div>
            </div>

            {{-- Status badges row --}}
            <div class="flex items-center flex-wrap gap-2 mt-4 pt-4 border-t border-slate-100">
                <span class="flex items-center gap-1.5 px-3 py-1 bg-blue-50 text-blue-700 rounded-lg text-xs font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                    {{ $patient->patient_number ?? 'ID Pending' }}
                </span>
                @if($patient->blood_group)
                    <span class="px-3 py-1 bg-red-50 text-red-700 rounded-lg text-xs font-bold">🩸 {{ $patient->blood_group }}</span>
                @endif
                @if($patient->genotype)
                    <span class="px-3 py-1 bg-amber-50 text-amber-700 rounded-lg text-xs font-bold">🧬 {{ $patient->genotype }}</span>
                @endif
                @if($patient->marital_status)
                    <span class="px-3 py-1 bg-violet-50 text-violet-700 rounded-lg text-xs font-bold capitalize">{{ $patient->marital_status }}</span>
                @endif
                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold">
                    Registered {{ $patient->created_at->format('M d, Y') }}
                </span>
            </div>
        </div>
    </div>

    {{-- ── MAIN GRID ─────────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Left: Personal Details --}}
        <div class="space-y-5">

            {{-- Contact info --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <h2 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <div class="w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    Personal Details
                </h2>
                <dl class="space-y-3">
                    @foreach([
                        ['Date of Birth', $patient->date_of_birth?->format('M d, Y') ?? '—'],
                        ['Phone',         $patient->phone],
                        ['Email',         $patient->email ?: 'Not provided'],
                        ['Gender',        ucfirst($patient->gender ?? '—')],
                        ['Marital Status',ucfirst($patient->marital_status ?? '—')],
                    ] as [$label, $value])
                        <div class="flex items-start justify-between gap-2 pb-3 border-b border-slate-50 last:border-0 last:pb-0">
                            <dt class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide flex-shrink-0">{{ $label }}</dt>
                            <dd class="text-xs font-semibold text-slate-700 text-right">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            {{-- Address --}}
            @if($patient->address || $patient->city)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <h2 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
                        <div class="w-7 h-7 bg-violet-50 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        Address
                    </h2>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        {{ implode(', ', array_filter([$patient->address, $patient->city, $patient->state, $patient->country])) }}
                    </p>
                </div>
            @endif

            {{-- Next of Kin --}}
            @if($patient->next_of_kin_name)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <h2 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <div class="w-7 h-7 bg-amber-50 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        Next of Kin
                    </h2>
                    <dl class="space-y-3">
                        @foreach([
                            ['Name', $patient->next_of_kin_name],
                            ['Phone', $patient->next_of_kin_phone ?? '—'],
                            ['Relationship', ucfirst($patient->next_of_kin_relationship ?? '—')],
                        ] as [$label,$value])
                            <div class="flex justify-between gap-2 pb-3 border-b border-slate-50 last:border-0 last:pb-0">
                                <dt class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">{{ $label }}</dt>
                                <dd class="text-xs font-semibold text-slate-700">{{ $value }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            @endif

            {{-- Emergency Contact --}}
            @if($patient->emergency_contact_name)
                <div class="bg-red-50 border border-red-100 rounded-2xl p-5">
                    <h2 class="text-sm font-bold text-red-800 mb-3 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        Emergency Contact
                    </h2>
                    <p class="text-xs font-bold text-red-800">{{ $patient->emergency_contact_name }}</p>
                    <p class="text-xs text-red-600 mt-0.5">{{ $patient->emergency_contact_phone }}</p>
                </div>
            @endif
        </div>

        {{-- Right: Medical & Activity (2 cols) --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Medical Summary --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <h2 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <div class="w-7 h-7 bg-rose-50 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    Medical Summary
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @foreach([
                        ['Blood Group', $patient->blood_group ?? '—', 'bg-red-50 text-red-700'],
                        ['Genotype',    $patient->genotype   ?? '—', 'bg-amber-50 text-amber-700'],
                        ['Total Visits', $visits->count(),           'bg-blue-50 text-blue-700'],
                        ['Vitals Taken', $vitals->count(),           'bg-emerald-50 text-emerald-700'],
                    ] as [$label, $val, $badge])
                        <div class="text-center p-4 rounded-2xl {{ $badge }} border border-current/10">
                            <p class="text-xl font-black">{{ $val }}</p>
                            <p class="text-[11px] font-semibold mt-1 opacity-80">{{ $label }}</p>
                        </div>
                    @endforeach
                </div>
                @if($patient->allergies)
                    <div class="mt-4 p-3 bg-orange-50 border border-orange-200 rounded-xl">
                        <p class="text-xs font-bold text-orange-800 flex items-center gap-1.5 mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            Known Allergies
                        </p>
                        <p class="text-xs text-orange-700">{{ $patient->allergies }}</p>
                    </div>
                @endif
            </div>

            {{-- Recent Vitals --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                    <h2 class="text-sm font-bold text-slate-800">Recent Vitals</h2>
                    <span class="text-xs text-slate-400">Last {{ $vitals->count() }} records</span>
                </div>
                @if($vitals->count())
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs">
                            <thead>
                                <tr class="bg-slate-50/80 border-b border-slate-100">
                                    @foreach(['Date','Temp (°C)','BP (mmHg)','Pulse','Weight (kg)','Recorded By'] as $h)
                                        <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">{{ $h }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($vitals as $vital)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-4 py-3 font-semibold text-slate-700">{{ $vital->recorded_at->format('M d, Y') }}</td>
                                        <td class="px-4 py-3 text-slate-600">{{ $vital->temperature ?? '—' }}</td>
                                        <td class="px-4 py-3 text-slate-600">
                                            {{ $vital->blood_pressure_systolic && $vital->blood_pressure_diastolic
                                                ? $vital->blood_pressure_systolic.'/'.$vital->blood_pressure_diastolic
                                                : '—' }}
                                        </td>
                                        <td class="px-4 py-3 text-slate-600">{{ $vital->pulse_rate ?? '—' }}</td>
                                        <td class="px-4 py-3 text-slate-600">{{ $vital->weight ?? '—' }}</td>
                                        <td class="px-4 py-3 text-slate-500">{{ $vital->recordedBy?->name ?? 'System' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="py-10 text-center">
                        <p class="text-sm font-semibold text-slate-700">No vitals recorded yet.</p>
                        <p class="text-xs text-slate-400 mt-1">Record the patient's first vitals below.</p>
                    </div>
                @endif

                {{-- Add Vitals Form --}}
                <div class="border-t border-slate-100 p-5" x-data="{ open: false }">
                    <button type="button" @click="open=!open"
                            class="flex items-center gap-2 text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        <span x-text="open ? 'Cancel' : 'Record New Vitals'"></span>
                    </button>
                    <div x-show="open" x-transition class="mt-4" style="display:none;">
                        <form method="POST" action="{{ route('patients.vitals.store', $patient) }}" class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @csrf
                            @foreach([['temperature','Temperature (°C)'],['pulse_rate','Pulse (bpm)'],['weight','Weight (kg)'],['blood_pressure_systolic','BP Systolic'],['blood_pressure_diastolic','BP Diastolic'],['recorded_at','Date & Time']] as [$name,$label])
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">{{ $label }}</label>
                                    <input name="{{ $name }}" type="{{ $name==='recorded_at'?'datetime-local':'number' }}" step="0.01"
                                           value="{{ $name==='recorded_at'?now()->format('Y-m-d\TH:i'):'' }}"
                                           class="w-full px-3 py-2 text-xs border border-slate-200 bg-slate-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors">
                                </div>
                            @endforeach
                            <div class="col-span-2 sm:col-span-3">
                                <button type="submit" class="px-5 py-2 text-white text-xs font-bold rounded-xl shadow-sm transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                                    Save Vitals
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Recent Visits --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                    <h2 class="text-sm font-bold text-slate-800">Visit History</h2>
                    <span class="text-xs text-slate-400">Last {{ $visits->count() }} visits</span>
                </div>
                @if($visits->count())
                    <div class="divide-y divide-slate-50">
                        @foreach($visits as $visit)
                            <div class="flex items-start gap-4 px-5 py-4 hover:bg-slate-50/50 transition-colors">
                                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5
                                            {{ match($visit->visit_type??'') {
                                                'emergency'=>'bg-red-50 text-red-600',
                                                'admission'=>'bg-violet-50 text-violet-600',
                                                default=>'bg-blue-50 text-blue-600'
                                            } }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2">
                                        <p class="text-xs font-bold text-slate-800 capitalize">{{ str_replace('-',' ',$visit->visit_type ?? 'Consultation') }}</p>
                                        <span class="text-[11px] text-slate-400 flex-shrink-0">{{ $visit->visit_date->format('M d, Y') }}</span>
                                    </div>
                                    @if($visit->chief_complaint)
                                        <p class="text-[11px] text-slate-600 mt-0.5 line-clamp-2">{{ $visit->chief_complaint }}</p>
                                    @endif
                                    @if($visit->diagnosis)
                                        <p class="text-[11px] text-blue-600 font-medium mt-1">Dx: {{ $visit->diagnosis }}</p>
                                    @endif
                                    <p class="text-[10px] text-slate-400 mt-1">Attended by: {{ $visit->attendedBy?->name ?? 'Not assigned' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-10 text-center">
                        <p class="text-sm font-semibold text-slate-700">No visits recorded yet.</p>
                        <p class="text-xs text-slate-400 mt-1">Log the patient's first visit below.</p>
                    </div>
                @endif

                {{-- Add Visit Form --}}
                <div class="border-t border-slate-100 p-5" x-data="{ open: false }">
                    <button type="button" @click="open=!open"
                            class="flex items-center gap-2 text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        <span x-text="open ? 'Cancel' : 'Log New Visit'"></span>
                    </button>
                    <div x-show="open" x-transition class="mt-4 space-y-3" style="display:none;">
                        <form method="POST" action="{{ route('patients.visits.store', $patient) }}" class="space-y-3">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Visit Type</label>
                                    <select name="visit_type" class="w-full px-3 py-2 text-xs border border-slate-200 bg-slate-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700">
                                        @foreach($visitTypes as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Visit Date</label>
                                    <input name="visit_date" type="date" value="{{ now()->format('Y-m-d') }}"
                                           class="w-full px-3 py-2 text-xs border border-slate-200 bg-slate-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors">
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Chief Complaint</label>
                                    <textarea name="chief_complaint" rows="2" placeholder="Patient's main complaint…"
                                              class="w-full px-3 py-2 text-xs border border-slate-200 bg-slate-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors resize-none placeholder-slate-400"></textarea>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Diagnosis</label>
                                    <textarea name="diagnosis" rows="2" placeholder="Clinical diagnosis…"
                                              class="w-full px-3 py-2 text-xs border border-slate-200 bg-slate-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors resize-none placeholder-slate-400"></textarea>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Treatment & Notes</label>
                                    <textarea name="treatment" rows="2" placeholder="Treatment prescribed or notes…"
                                              class="w-full px-3 py-2 text-xs border border-slate-200 bg-slate-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors resize-none placeholder-slate-400"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="px-5 py-2 text-white text-xs font-bold rounded-xl shadow-sm transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                                Save Visit
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Notes --}}
            @if($patient->notes)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <h2 class="text-sm font-bold text-slate-800 mb-3">Clinical Notes</h2>
                    <p class="text-xs text-slate-600 leading-relaxed">{{ $patient->notes }}</p>
                </div>
            @endif

        </div>
    </div>

</div>
</x-admin-layout>
