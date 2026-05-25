<x-admin-layout title="Edit Doctor – {{ $doctor->full_name }}">
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Breadcrumb & Header --}}
    <div>
        <div class="flex items-center gap-2 text-xs text-slate-400 mb-3">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('modules.doctors.index') }}" class="hover:text-blue-600 transition-colors">Doctors</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('modules.doctors.show', $doctor) }}" class="hover:text-blue-600 transition-colors truncate max-w-[100px]">{{ $doctor->full_name }}</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-slate-600 font-semibold">Edit</span>
        </div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Edit Doctor Profile</h1>
        <p class="text-sm text-slate-500 mt-1">Update details and status for {{ $doctor->full_name }}</p>
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
    <form method="POST" action="{{ route('modules.doctors.update', $doctor) }}" class="bg-white border border-slate-100 shadow-sm rounded-2xl overflow-hidden">
        @csrf
        @method('PUT')
        
        <div class="p-6 sm:p-8 space-y-8">
            {{-- Personal Info Section --}}
            <div>
                <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2 border-b border-slate-100 pb-2">
                    <div class="w-6 h-6 bg-blue-50 text-blue-600 rounded flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                    Personal Details
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">First Name <span class="text-red-500">*</span></label>
                        <input type="text" name="first_name" value="{{ old('first_name', $doctor->first_name) }}" required 
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" name="last_name" value="{{ old('last_name', $doctor->last_name) }}" required 
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Phone Number <span class="text-red-500">*</span></label>
                        <input type="tel" name="phone" value="{{ old('phone', $doctor->phone) }}" required 
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $doctor->email) }}" 
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                    </div>
                </div>
            </div>

            {{-- Professional Info Section --}}
            <div>
                <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2 border-b border-slate-100 pb-2">
                    <div class="w-6 h-6 bg-violet-50 text-violet-600 rounded flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg></div>
                    Professional Details
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Specialization <span class="text-red-500">*</span></label>
                        <select name="specialization" required class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700">
                            <option value="">Select Specialization...</option>
                            @php $currSpec = old('specialization', $doctor->specialization); @endphp
                            @foreach(['General Practitioner','Cardiologist','Neurologist','Orthopedic Surgeon','Dentist','Endocrinologist','Pediatrician','Gynecologist'] as $spec)
                                <option value="{{ $spec }}" {{ $currSpec===$spec ? 'selected':'' }}>{{ $spec }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Medical License Number <span class="text-red-500">*</span></label>
                        <input type="text" name="license_number" value="{{ old('license_number', $doctor->license_number) }}" required 
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400 font-mono uppercase">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Employment Status <span class="text-red-500">*</span></label>
                        <select name="status" required class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700">
                            @php $currStatus = old('status', $doctor->status); @endphp
                            <option value="active" {{ $currStatus==='active' ? 'selected':'' }}>Active</option>
                            <option value="on_leave" {{ $currStatus==='on_leave' ? 'selected':'' }}>On Leave</option>
                            <option value="inactive" {{ $currStatus==='inactive' ? 'selected':'' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Biography & Notes</label>
                        <textarea name="bio" rows="4" 
                                  class="w-full px-4 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400 resize-none">{{ old('bio', $doctor->bio) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="px-6 sm:px-8 py-5 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-3">
            {{-- Delete form handled separately outside to avoid nesting forms, but we can put a button here --}}
            <button type="button" x-data @click="if(confirm('Are you sure you want to remove this doctor?')) { document.getElementById('delete-doctor-form').submit(); }" class="px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-50 rounded-xl transition-colors">
                Remove Doctor
            </button>
            <div class="flex items-center gap-3">
                <a href="{{ route('modules.doctors.show', $doctor) }}" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200 hover:bg-slate-100 rounded-xl transition-colors">Cancel</a>
                <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                    Save Changes
                </button>
            </div>
        </div>
    </form>

    {{-- Hidden Delete Form --}}
    <form id="delete-doctor-form" method="POST" action="{{ route('modules.doctors.destroy', $doctor) }}" class="hidden">
        @csrf
        @method('DELETE')
    </form>

</div>
</x-admin-layout>
