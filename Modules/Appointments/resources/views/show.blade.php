<x-admin-layout title="Appointment Details">
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Breadcrumb & Header --}}
    <div>
        <div class="flex items-center gap-2 text-xs text-slate-400 mb-3">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
            <x-fas-chevron-right class="w-3 h-3" />
            <a href="{{ route('modules.appointments.index') }}" class="hover:text-blue-600 transition-colors">Appointments</a>
            <x-fas-chevron-right class="w-3 h-3" />
            <span class="text-slate-600 font-semibold">Appointment #{{ $appointment->id }}</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Appointment Details</h1>
                <p class="text-sm text-slate-500 mt-1">Review full scheduling info and clinical notes.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('modules.appointments.edit', $appointment) }}" class="flex items-center gap-2 px-5 py-2 text-sm font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                    <x-fas-pen class="w-4 h-4" />
                    Reschedule / Edit
                </a>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        {{-- Status Header Banner --}}
        @php
            $statusColors = [
                'pending' => 'bg-amber-50 text-amber-700 border-b border-amber-100',
                'confirmed' => 'bg-blue-50 text-blue-700 border-b border-blue-100',
                'completed' => 'bg-emerald-50 text-emerald-700 border-b border-emerald-100',
                'cancelled' => 'bg-slate-100 text-slate-600 border-b border-slate-200'
            ];
            $colorClass = $statusColors[$appointment->status] ?? $statusColors['pending'];
        @endphp
        <div class="px-6 py-4 {{ $colorClass }} flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-2.5">
                @if($appointment->status === 'completed')
                    <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center shadow-sm">
                        <x-fas-eye class="w-5 h-5" />
                    </div>
                    <span class="font-bold uppercase tracking-wide text-sm">Completed Appointment</span>
                @elseif($appointment->status === 'confirmed')
                    <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center shadow-sm">
                        <x-fas-pen class="w-5 h-5" />
                    </div>
                    <span class="font-bold uppercase tracking-wide text-sm">Confirmed Appointment</span>
                @elseif($appointment->status === 'cancelled')
                    <div class="w-8 h-8 rounded-full bg-slate-400 text-white flex items-center justify-center shadow-sm">
                        <x-fas-pen class="w-5 h-5" />
                    </div>
                    <span class="font-bold uppercase tracking-wide text-sm">Cancelled Appointment</span>
                @else
                    <div class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center shadow-sm">
                        <x-fas-chart-bar class="w-5 h-5" />
                    </div>
                    <span class="font-bold uppercase tracking-wide text-sm">Pending Confirmation</span>
                @endif
            </div>
            <div class="text-right">
                <p class="text-xs font-semibold opacity-70">Scheduled For</p>
                <p class="text-base font-black">{{ $appointment->appointment_date->format('l, M d, Y') }} at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
            </div>
        </div>

        <div class="p-6 sm:p-8 space-y-8">
            
            {{-- People Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative">
                <div class="hidden md:block absolute left-1/2 top-0 bottom-0 w-px bg-slate-100 -translate-x-1/2"></div>
                
                {{-- Patient Info --}}
                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <x-fas-file-alt class="w-4 h-4 text-slate-300" />
                        Patient
                    </h3>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 font-black text-xl flex items-center justify-center flex-shrink-0 border border-blue-100 shadow-sm">
                            {{ strtoupper(substr($appointment->patient->first_name,0,1).substr($appointment->patient->last_name,0,1)) }}
                        </div>
                        <div>
                            <p class="text-lg font-black text-slate-900">{{ $appointment->patient->full_name }}</p>
                            <p class="text-sm text-slate-500 font-mono mt-0.5">{{ $appointment->patient->patient_number }}</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-50 space-y-2">
                        <p class="text-sm flex items-center gap-2"><span class="w-16 text-slate-400 text-xs font-semibold">Phone</span> <span class="font-medium text-slate-700">{{ $appointment->patient->phone ?? '—' }}</span></p>
                        <p class="text-sm flex items-center gap-2"><span class="w-16 text-slate-400 text-xs font-semibold">Email</span> <span class="font-medium text-slate-700">{{ $appointment->patient->email ?? '—' }}</span></p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('patients.show', $appointment->patient->uuid) }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors inline-flex items-center gap-1">
                            View Full Medical Record <x-fas-file-medical class="w-3 h-3" />
                        </a>
                    </div>
                </div>

                {{-- Doctor Info --}}
                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <x-fas-file-alt class="w-4 h-4 text-slate-300" />
                        Doctor
                    </h3>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 font-black text-xl flex items-center justify-center flex-shrink-0 border border-indigo-100 shadow-sm">
                            {{ strtoupper(substr($appointment->doctor->first_name,0,1).substr($appointment->doctor->last_name,0,1)) }}
                        </div>
                        <div>
                            <p class="text-lg font-black text-slate-900">{{ $appointment->doctor->full_name }}</p>
                            <span class="inline-block mt-1 px-2.5 py-0.5 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-600">
                                {{ $appointment->doctor->specialization }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-50 space-y-2">
                        <p class="text-sm flex items-center gap-2"><span class="w-16 text-slate-400 text-xs font-semibold">License</span> <span class="font-mono text-slate-700">{{ $appointment->doctor->license_number }}</span></p>
                        <p class="text-sm flex items-center gap-2"><span class="w-16 text-slate-400 text-xs font-semibold">Contact</span> <span class="font-medium text-slate-700">{{ $appointment->doctor->phone }}</span></p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('modules.doctors.show', $appointment->doctor) }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors inline-flex items-center gap-1">
                            View Doctor Profile <x-fas-user-md class="w-3 h-3" />
                        </a>
                    </div>
                </div>
            </div>

            {{-- Appointment Details --}}
            <div class="pt-8 border-t border-slate-100">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-5 flex items-center gap-2">
                    <x-fas-file-alt class="w-4 h-4 text-slate-300" />
                    Reason & Notes
                </h3>
                
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                    <p class="text-sm font-bold text-slate-800 mb-2">Reason for Visit</p>
                    <p class="text-base text-slate-700 mb-6">{{ $appointment->reason }}</p>

                    <p class="text-sm font-bold text-slate-800 mb-2">Additional Notes</p>
                    @if($appointment->notes)
                        <div class="prose prose-sm text-slate-600">
                            {!! nl2br(e($appointment->notes)) !!}
                        </div>
                    @else
                        <p class="text-sm text-slate-400 italic">No additional notes provided.</p>
                    @endif
                </div>
            </div>
            
            <div class="text-right">
                <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Record Created On</p>
                <p class="text-xs font-semibold text-slate-500">{{ $appointment->created_at->format('M d, Y h:i A') }}</p>
            </div>
        </div>
    </div>

</div>
</x-admin-layout>
