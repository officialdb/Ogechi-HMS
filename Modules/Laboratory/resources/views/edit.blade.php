<x-admin-layout title="Update Lab Test">
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('modules.laboratory.index') }}"
           class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Update Lab Test</h1>
            <p class="text-sm text-slate-500 mt-0.5">Edit test details or input results.</p>
        </div>
    </div>

    {{-- Form --}}
    <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm">
        <form action="{{ route('modules.laboratory.update', $laboratory) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-2xl p-4 text-sm text-red-700 space-y-1">
                    @foreach($errors->all() as $error)
                        <p class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- Patient --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Patient <span class="text-red-500">*</span></label>
                    <select name="patient_id" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium">
                        <option value="">Select Patient...</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id', $laboratory->patient_id) == $patient->id ? 'selected' : '' }}>
                                {{ $patient->first_name }} {{ $patient->last_name }} ({{ $patient->patient_number }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Doctor --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Requesting Doctor</label>
                    <select name="doctor_id"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium">
                        <option value="">None / External</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id', $laboratory->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                Dr. {{ $doctor->last_name }} ({{ $doctor->specialization }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- Test Name --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Test Name <span class="text-red-500">*</span></label>
                    <input type="text" name="test_name" value="{{ old('test_name', $laboratory->test_name) }}" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium">
                </div>

                {{-- Test Type --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Test Type <span class="text-red-500">*</span></label>
                    <select name="test_type" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium">
                        <option value="">Select Type...</option>
                        @foreach(['Blood', 'Urine', 'X-Ray', 'MRI', 'Ultrasound', 'Biopsy', 'Other'] as $type)
                            <option value="{{ strtolower($type) }}" {{ old('test_type', $laboratory->test_type) === strtolower($type) ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- Status --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Status <span class="text-red-500">*</span></label>
                    <select name="status" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium">
                        <option value="pending" {{ old('status', $laboratory->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ old('status', $laboratory->status) === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ old('status', $laboratory->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status', $laboratory->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                {{-- Cost --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Cost ($) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="cost" value="{{ old('cost', $laboratory->cost) }}" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- Notes --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Clinical Notes</label>
                    <textarea name="notes" rows="4"
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium resize-none">{{ old('notes', $laboratory->notes) }}</textarea>
                </div>

                {{-- Results --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Test Results</label>
                    <textarea name="result" rows="4"
                              placeholder="Enter the lab findings here..."
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium resize-none">{{ old('result', $laboratory->result) }}</textarea>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                <form method="POST" action="{{ route('modules.laboratory.destroy', $laboratory) }}" onsubmit="return confirm('Are you sure you want to delete this lab test?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-bold text-red-700 bg-red-50 border border-red-200 rounded-xl hover:bg-red-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Delete
                    </button>
                </form>

                <div class="flex items-center gap-3">
                    <a href="{{ route('modules.laboratory.index') }}"
                       class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white rounded-xl shadow-md shadow-blue-500/20 transition-all hover:opacity-90 hover:scale-[1.02]"
                            style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
</x-admin-layout>
