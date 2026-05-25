<x-admin-layout title="Edit Appointment">
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Breadcrumb & Header --}}
    <div>
        <div class="flex items-center gap-2 text-xs text-slate-400 mb-3">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('modules.appointments.index') }}" class="hover:text-blue-600 transition-colors">Appointments</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('modules.appointments.show', $appointment) }}" class="hover:text-blue-600 transition-colors">Details</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-slate-600 font-semibold">Reschedule</span>
        </div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Edit Appointment</h1>
        <p class="text-sm text-slate-500 mt-1">Reschedule or change the status of this appointment.</p>
    </div>

    @if($errors->any())
        <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium border border-red-100">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form method="POST" action="{{ route('modules.appointments.update', $appointment) }}" class="bg-white border border-slate-100 shadow-sm rounded-2xl overflow-hidden">
        @csrf
        @method('PUT')
        
        <div class="p-6 sm:p-8 space-y-8">
            {{-- Participants --}}
            <div>
                <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2 border-b border-slate-100 pb-2">
                    <div class="w-6 h-6 bg-blue-50 text-blue-600 rounded flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                    Participants
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Select Patient <span class="text-red-500">*</span></label>
                        <select name="patient_id" required class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700">
                            <option value="">Choose Patient...</option>
                            @php $currPat = old('patient_id', $appointment->patient_id); @endphp
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ $currPat == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->full_name }} ({{ $patient->patient_number }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Select Doctor <span class="text-red-500">*</span></label>
                        <select name="doctor_id" required class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700">
                            <option value="">Choose Doctor...</option>
                            @php $currDoc = old('doctor_id', $appointment->doctor_id); @endphp
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ $currDoc == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->full_name }} — {{ $doctor->specialization }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Scheduling Info --}}
            <div>
                <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2 border-b border-slate-100 pb-2">
                    <div class="w-6 h-6 bg-violet-50 text-violet-600 rounded flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                    Schedule Details
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Date <span class="text-red-500">*</span></label>
                        <input type="date" name="appointment_date" value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}" required 
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Time <span class="text-red-500">*</span></label>
                        @php $timeVal = old('appointment_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')); @endphp
                        <input type="time" name="appointment_time" value="{{ $timeVal }}" required 
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                        <select name="status" required class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700 font-bold">
                            @php $currStatus = old('status', $appointment->status); @endphp
                            <option value="pending" {{ $currStatus==='pending' ? 'selected':'' }}>Pending</option>
                            <option value="confirmed" {{ $currStatus==='confirmed' ? 'selected':'' }}>Confirmed</option>
                            <option value="completed" {{ $currStatus==='completed' ? 'selected':'' }}>Completed</option>
                            <option value="cancelled" {{ $currStatus==='cancelled' ? 'selected':'' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Reason for Visit <span class="text-red-500">*</span></label>
                        <input type="text" name="reason" value="{{ old('reason', $appointment->reason) }}" required 
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Additional Notes (Optional)</label>
                        <textarea name="notes" rows="3" 
                                  class="w-full px-4 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400 resize-none">{{ old('notes', $appointment->notes) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="px-6 sm:px-8 py-5 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-3">
            <button type="button" x-data @click="if(confirm('Are you sure you want to completely remove this appointment? This cannot be undone.')) { document.getElementById('delete-apt-form').submit(); }" class="px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-50 rounded-xl transition-colors">
                Delete Record
            </button>
            <div class="flex items-center gap-3">
                <a href="{{ route('modules.appointments.show', $appointment) }}" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200 hover:bg-slate-100 rounded-xl transition-colors">Cancel</a>
                <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                    Save Changes
                </button>
            </div>
        </div>
    </form>

    <form id="delete-apt-form" method="POST" action="{{ route('modules.appointments.destroy', $appointment) }}" class="hidden">
        @csrf
        @method('DELETE')
    </form>

</div>
</x-admin-layout>
