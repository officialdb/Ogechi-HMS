<x-admin-layout title="New Lab Test">
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('modules.laboratory.index') }}"
           class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-colors shadow-sm">
            <x-fas-eye class="w-4 h-4" />
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Request Lab Test</h1>
            <p class="text-sm text-slate-500 mt-0.5">Order a new test for a patient.</p>
        </div>
    </div>

    {{-- Form --}}
    <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm">
        <form action="{{ route('modules.laboratory.store') }}" method="POST" class="space-y-6">
            @csrf

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-2xl p-4 text-sm text-red-700 space-y-1">
                    @foreach($errors->all() as $error)
                        <p class="flex items-center gap-2"><x-fas-eye class="w-4 h-4 shrink-0" />{{ $error }}</p>
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
                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
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
                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
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
                    <input type="text" name="test_name" value="{{ old('test_name') }}" required
                           placeholder="e.g. Complete Blood Count (CBC)"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium">
                </div>

                {{-- Test Type --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Test Type <span class="text-red-500">*</span></label>
                    <select name="test_type" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium">
                        <option value="">Select Type...</option>
                        @foreach(['Blood', 'Urine', 'X-Ray', 'MRI', 'Ultrasound', 'Biopsy', 'Other'] as $type)
                            <option value="{{ strtolower($type) }}" {{ old('test_type') === strtolower($type) ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Cost --}}
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Cost ($) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="cost" value="{{ old('cost', '0.00') }}" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium">
            </div>

            {{-- Notes --}}
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Clinical Notes / Instructions</label>
                <textarea name="notes" rows="3"
                          placeholder="Fasting required, specific parameters to check..."
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium resize-none">{{ old('notes') }}</textarea>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('modules.laboratory.index') }}"
                   class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white rounded-xl shadow-md shadow-blue-500/20 transition-all hover:opacity-90 hover:scale-[1.02]"
                        style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                    <x-fas-eye class="w-4 h-4" />
                    Request Test
                </button>
            </div>
        </form>
    </div>
</div>
</x-admin-layout>
