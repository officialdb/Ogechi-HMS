<x-admin-layout title="Register Patient">
<div class="max-w-4xl mx-auto space-y-5"
     x-data="{ step: 1, maxStep: 3 }">

    {{-- ── BREADCRUMB ─────────────────────────────────── --}}
    <div class="flex items-center gap-2">
        <a href="{{ route('dashboard') }}" class="text-xs text-slate-400 hover:text-blue-600 transition-colors">Dashboard</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('patients.index') }}" class="text-xs text-slate-400 hover:text-blue-600 transition-colors">Patients</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="text-xs text-blue-600 font-semibold">Register Patient</span>
    </div>

    {{-- ── HEADING ─────────────────────────────────────── --}}
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Register New Patient</h1>
            <p class="text-sm text-slate-500 mt-0.5">Complete all sections to create a full patient record.</p>
        </div>
        <a href="{{ route('patients.index') }}" class="flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back
        </a>
    </div>

    {{-- ── STEP INDICATOR ────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <div class="flex items-center">
            @foreach([['1','Personal Info'],['2','Medical Info'],['3','Emergency & Notes']] as $i => [$num,$label])
                <div class="flex items-center {{ $i < 2 ? 'flex-1' : '' }}">
                    <div class="flex items-center gap-2.5">
                        <div :class="step >= {{ $num }} ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'bg-slate-100 text-slate-400'"
                             class="w-8 h-8 rounded-xl flex items-center justify-center text-xs font-black transition-all duration-300">
                            <span x-show="step <= {{ $num }}">{{ $num }}</span>
                            <svg x-show="step > {{ $num }}" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div class="hidden sm:block">
                            <p :class="step >= {{ $num }} ? 'text-blue-600 font-bold' : 'text-slate-400'"
                               class="text-xs font-semibold leading-none transition-colors">{{ $label }}</p>
                        </div>
                    </div>
                    @if($i < 2)
                        <div class="flex-1 mx-3 h-0.5 rounded-full transition-all duration-500"
                             :class="step > {{ $num }} ? 'bg-blue-500' : 'bg-slate-200'"></div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    {{-- ── FORM ────────────────────────────────────────── --}}
    <form method="POST" action="{{ route('patients.store') }}" class="space-y-5">
        @csrf

        {{-- Validation errors --}}
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-2xl px-5 py-4">
                <p class="text-sm font-bold text-red-800 mb-2">Please fix the following errors:</p>
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li class="text-xs text-red-700 flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ── STEP 1: Personal Info ── --}}
        <div x-show="step === 1" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100" style="background:linear-gradient(135deg,#EFF6FF,#DBEAFE);">
                    <div class="w-8 h-8 rounded-xl bg-blue-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-blue-900">Personal Information</h2>
                        <p class="text-[11px] text-blue-600">Basic details and contact information</p>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @php
                        $field = fn($name,$label,$type='text',$placeholder='') =>
                            ['name'=>$name,'label'=>$label,'type'=>$type,'placeholder'=>$placeholder,'required'=>true];
                    @endphp

                    {{-- First Name --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">First Name <span class="text-red-500">*</span></label>
                        <input name="first_name" type="text" value="{{ old('first_name') }}" required placeholder="e.g. Amaka"
                               class="w-full px-4 py-2.5 text-sm border {{ $errors->has('first_name') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-slate-50' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                        @error('first_name') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Middle Name --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Middle Name</label>
                        <input name="middle_name" type="text" value="{{ old('middle_name') }}" placeholder="Optional"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 bg-slate-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                    </div>

                    {{-- Last Name --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Last Name <span class="text-red-500">*</span></label>
                        <input name="last_name" type="text" value="{{ old('last_name') }}" required placeholder="e.g. Okafor"
                               class="w-full px-4 py-2.5 text-sm border {{ $errors->has('last_name') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-slate-50' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                        @error('last_name') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Date of Birth --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Date of Birth <span class="text-red-500">*</span></label>
                        <input name="date_of_birth" type="date" value="{{ old('date_of_birth') }}" required max="{{ date('Y-m-d') }}"
                               class="w-full px-4 py-2.5 text-sm border {{ $errors->has('date_of_birth') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-slate-50' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700">
                        @error('date_of_birth') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Gender --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Gender <span class="text-red-500">*</span></label>
                        <select name="gender" required class="w-full px-4 py-2.5 text-sm border {{ $errors->has('gender') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-slate-50' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700">
                            <option value="">Select gender</option>
                            @foreach($selectOptions['genders'] as $value => $label)
                                <option value="{{ $value }}" {{ old('gender') === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('gender') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Marital Status --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Marital Status</label>
                        <select name="marital_status" class="w-full px-4 py-2.5 text-sm border border-slate-200 bg-slate-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700">
                            <option value="">Select status</option>
                            @foreach($selectOptions['maritalStatuses'] as $value => $label)
                                <option value="{{ $value }}" {{ old('marital_status') === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Phone Number <span class="text-red-500">*</span></label>
                        <input name="phone" type="tel" value="{{ old('phone') }}" required placeholder="+234 800 000 0000"
                               class="w-full px-4 py-2.5 text-sm border {{ $errors->has('phone') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-slate-50' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                        @error('phone') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Email Address</label>
                        <input name="email" type="email" value="{{ old('email') }}" placeholder="patient@email.com"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 bg-slate-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                    </div>

                    {{-- Address (full width) --}}
                    <div class="sm:col-span-2 lg:col-span-3">
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Home Address</label>
                        <input name="address" type="text" value="{{ old('address') }}" placeholder="Street address"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 bg-slate-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                    </div>

                    {{-- City / State / Country --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">City</label>
                        <input name="city" type="text" value="{{ old('city') }}" placeholder="e.g. Enugu"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 bg-slate-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">State</label>
                        <input name="state" type="text" value="{{ old('state') }}" placeholder="e.g. Enugu State"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 bg-slate-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Country</label>
                        <input name="country" type="text" value="{{ old('country','Nigeria') }}" placeholder="Nigeria"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 bg-slate-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button type="button" @click="step = 2"
                        class="flex items-center gap-2 px-6 py-3 text-white text-sm font-bold rounded-xl shadow-md transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                    Next: Medical Info
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </button>
            </div>
        </div>

        {{-- ── STEP 2: Medical Info ── --}}
        <div x-show="step === 2" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display:none;">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100" style="background:linear-gradient(135deg,#F0FDF4,#DCFCE7);">
                    <div class="w-8 h-8 rounded-xl bg-emerald-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-emerald-900">Medical Information</h2>
                        <p class="text-[11px] text-emerald-700">Blood group, genotype, and known allergies</p>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Blood Group</label>
                        <select name="blood_group" class="w-full px-4 py-2.5 text-sm border border-slate-200 bg-slate-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700">
                            <option value="">Select blood group</option>
                            @foreach($selectOptions['bloodGroups'] as $value => $label)
                                <option value="{{ $value }}" {{ old('blood_group') === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Genotype</label>
                        <select name="genotype" class="w-full px-4 py-2.5 text-sm border border-slate-200 bg-slate-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700">
                            <option value="">Select genotype</option>
                            @foreach($selectOptions['genotypes'] as $value => $label)
                                <option value="{{ $value }}" {{ old('genotype') === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Known Allergies</label>
                        <textarea name="allergies" rows="3" placeholder="List any known allergies (medications, foods, environmental)…"
                                  class="w-full px-4 py-2.5 text-sm border border-slate-200 bg-slate-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors resize-none placeholder-slate-400">{{ old('allergies') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-between mt-4">
                <button type="button" @click="step = 1" class="flex items-center gap-2 px-5 py-3 bg-white border border-slate-200 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                    Back
                </button>
                <button type="button" @click="step = 3" class="flex items-center gap-2 px-6 py-3 text-white text-sm font-bold rounded-xl shadow-md transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                    Next: Emergency & Notes
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </button>
            </div>
        </div>

        {{-- ── STEP 3: Emergency & Notes ── --}}
        <div x-show="step === 3" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display:none;">
            <div class="space-y-4">
                {{-- Next of Kin --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100" style="background:linear-gradient(135deg,#FFF7ED,#FFEDD5);">
                        <div class="w-8 h-8 rounded-xl bg-amber-500 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-amber-900">Next of Kin</h2>
                            <p class="text-[11px] text-amber-700">Primary contact person</p>
                        </div>
                    </div>
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Full Name</label>
                            <input name="next_of_kin_name" type="text" value="{{ old('next_of_kin_name') }}" placeholder="Next of kin name"
                                   class="w-full px-4 py-2.5 text-sm border border-slate-200 bg-slate-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Phone</label>
                            <input name="next_of_kin_phone" type="tel" value="{{ old('next_of_kin_phone') }}" placeholder="+234 800 000 0000"
                                   class="w-full px-4 py-2.5 text-sm border border-slate-200 bg-slate-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Relationship</label>
                            <input name="next_of_kin_relationship" type="text" value="{{ old('next_of_kin_relationship') }}" placeholder="e.g. Spouse"
                                   class="w-full px-4 py-2.5 text-sm border border-slate-200 bg-slate-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                        </div>
                    </div>
                </div>

                {{-- Emergency Contact --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100" style="background:linear-gradient(135deg,#FFF1F2,#FFE4E6);">
                        <div class="w-8 h-8 rounded-xl bg-rose-500 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-rose-900">Emergency Contact</h2>
                            <p class="text-[11px] text-rose-700">Who to call in an emergency</p>
                        </div>
                    </div>
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Full Name</label>
                            <input name="emergency_contact_name" type="text" value="{{ old('emergency_contact_name') }}" placeholder="Emergency contact name"
                                   class="w-full px-4 py-2.5 text-sm border border-slate-200 bg-slate-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Phone</label>
                            <input name="emergency_contact_phone" type="tel" value="{{ old('emergency_contact_phone') }}" placeholder="+234 800 000 0000"
                                   class="w-full px-4 py-2.5 text-sm border border-slate-200 bg-slate-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                        </div>
                    </div>
                </div>

                {{-- Notes --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Clinical Notes</label>
                    <textarea name="notes" rows="4" placeholder="Any additional clinical notes, pre-existing conditions, or special requirements…"
                              class="w-full px-4 py-2.5 text-sm border border-slate-200 bg-slate-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors resize-none placeholder-slate-400">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="flex justify-between mt-4">
                <button type="button" @click="step = 2" class="flex items-center gap-2 px-5 py-3 bg-white border border-slate-200 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                    Back
                </button>
                <button type="submit" class="flex items-center gap-2 px-6 py-3 text-white text-sm font-bold rounded-xl shadow-md transition-all hover:opacity-90 hover:shadow-lg" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Register Patient
                </button>
            </div>
        </div>

    </form>
</div>
</x-admin-layout>
