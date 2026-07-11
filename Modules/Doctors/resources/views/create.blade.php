<x-admin-layout title="Register Doctor">
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Breadcrumb & Header --}}
    <div>
        <div class="flex items-center gap-2 text-xs text-slate-400 mb-3">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
            <x-fas-chevron-right class="w-3 h-3" />
            <a href="{{ route('modules.doctors.index') }}" class="hover:text-blue-600 transition-colors">Doctors</a>
            <x-fas-chevron-right class="w-3 h-3" />
            <span class="text-slate-600 font-semibold">Register New</span>
        </div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Register Doctor</h1>
        <p class="text-sm text-slate-500 mt-1">Add a new physician or specialist to the hospital directory.</p>
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
    <form method="POST" action="{{ route('modules.doctors.store') }}"
          enctype="multipart/form-data"
          class="bg-white border border-slate-100 shadow-sm rounded-2xl overflow-hidden">
        @csrf

        <div class="p-6 sm:p-8 space-y-8">

            {{-- ── Profile Photo Section ────────────────────────────── --}}
            <div x-data="{
                    preview: null,
                    handleFile(e) {
                        const file = e.target.files[0];
                        if (!file) return;
                        this.preview = URL.createObjectURL(file);
                    },
                    remove() {
                        this.preview = null;
                        this.$refs.fileInput.value = '';
                    }
                }">
                <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2 border-b border-slate-100 pb-2">
                    <div class="w-6 h-6 bg-blue-50 text-blue-600 rounded flex items-center justify-center">
                        <x-fas-camera class="w-3.5 h-3.5" />
                    </div>
                    Profile Photo <span class="text-xs font-normal text-slate-400 ml-1">(Optional)</span>
                </h3>

                <div class="flex items-center gap-6">
                    <div class="relative flex-shrink-0">
                        <div class="w-24 h-24 rounded-2xl overflow-hidden border-2 border-dashed border-slate-300 bg-slate-50 flex items-center justify-center">
                            <template x-if="preview">
                                <img :src="preview" class="w-full h-full object-cover" alt="Preview">
                            </template>
                            <template x-if="!preview">
                                <x-fas-user-md class="w-10 h-10 text-slate-300" />
                            </template>
                        </div>
                        <button type="button" x-show="preview" @click="remove()"
                                class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors shadow-md">
                            <x-fas-times class="w-3 h-3" />
                        </button>
                    </div>
                    <div class="flex-1">
                        <label class="flex items-center gap-2 cursor-pointer w-fit px-4 py-2.5 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-700 text-sm font-semibold rounded-xl transition-colors border border-slate-200 hover:border-blue-200">
                            <x-fas-upload class="w-4 h-4" />
                            <span x-text="preview ? 'Change Photo' : 'Upload Photo'"></span>
                            <input type="file" name="profile_photo" accept="image/*" class="hidden"
                                   x-ref="fileInput" @change="handleFile($event)">
                        </label>
                        <p class="text-xs text-slate-400 mt-2">JPG, PNG, GIF or WebP. Max 2MB.</p>
                    </div>
                </div>
            </div>

            {{-- ── Personal Info Section ──────────────────────────── --}}
            <div>
                <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2 border-b border-slate-100 pb-2">
                    <div class="w-6 h-6 bg-blue-50 text-blue-600 rounded flex items-center justify-center">
                        <x-fas-user class="w-3.5 h-3.5" />
                    </div>
                    Personal Details
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">First Name <span class="text-red-500">*</span></label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" required
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400" placeholder="e.g. Samuel">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" required
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400" placeholder="e.g. Okonkwo">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Phone Number <span class="text-red-500">*</span></label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" required
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400" placeholder="+234...">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400" placeholder="doctor@hospital.com">
                    </div>
                </div>
            </div>

            {{-- ── Professional Info Section ──────────────────────── --}}
            <div>
                <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2 border-b border-slate-100 pb-2">
                    <div class="w-6 h-6 bg-violet-50 text-violet-600 rounded flex items-center justify-center">
                        <x-fas-stethoscope class="w-3.5 h-3.5" />
                    </div>
                    Professional Details
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Specialization <span class="text-red-500">*</span></label>
                        <select name="specialization" required class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700">
                            <option value="">Select Specialization...</option>
                            @foreach(['General Practitioner','Cardiologist','Neurologist','Orthopedic Surgeon','Dentist','Endocrinologist','Pediatrician','Gynecologist'] as $spec)
                                <option value="{{ $spec }}" {{ old('specialization')===$spec ? 'selected':'' }}>{{ $spec }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Medical License Number <span class="text-red-500">*</span></label>
                        <input type="text" name="license_number" value="{{ old('license_number') }}" required
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400 font-mono uppercase" placeholder="MD-2026-XXXX">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Employment Status <span class="text-red-500">*</span></label>
                        <select name="status" required class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700">
                            <option value="active"   {{ old('status')==='active'   ? 'selected':'' }}>Active</option>
                            <option value="on_leave" {{ old('status')==='on_leave' ? 'selected':'' }}>On Leave</option>
                            <option value="inactive" {{ old('status')==='inactive' ? 'selected':'' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Biography & Notes</label>
                        <textarea name="bio" rows="4"
                                  class="w-full px-4 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400 resize-none"
                                  placeholder="Educational background, previous experience, and general notes...">{{ old('bio') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 sm:px-8 py-5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('modules.doctors.index') }}"
               class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200 hover:bg-slate-100 rounded-xl transition-colors">Cancel</a>
            <button type="submit"
                    class="flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90"
                    style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                <x-fas-user-plus class="w-4 h-4" />
                Save Doctor Profile
            </button>
        </div>
    </form>

</div>
</x-admin-layout>
