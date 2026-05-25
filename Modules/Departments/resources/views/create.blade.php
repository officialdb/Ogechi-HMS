<x-admin-layout title="New Department">
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('modules.departments.index') }}"
           class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">New Department</h1>
            <p class="text-sm text-slate-500 mt-0.5">Add a new hospital department.</p>
        </div>
    </div>

    {{-- Form --}}
    <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm">
        <form action="{{ route('modules.departments.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Validation errors --}}
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-2xl p-4 text-sm text-red-700 space-y-1">
                    @foreach($errors->all() as $error)
                        <p class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            {{-- Name --}}
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Department Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       placeholder="e.g. Cardiology, Radiology, Paediatrics"
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium @error('name') border-red-400 bg-red-50 @enderror">
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                <textarea name="description" rows="3"
                          placeholder="Brief description of this department's role and services…"
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium resize-none @error('description') border-red-400 bg-red-50 @enderror">{{ old('description') }}</textarea>
            </div>

            {{-- Head + Phone --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Head of Department</label>
                    <input type="text" name="head_of_department" value="{{ old('head_of_department') }}"
                           placeholder="Dr. Full Name"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium @error('head_of_department') border-red-400 @enderror">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Department Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                           placeholder="+234 800 000 0000"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium @error('phone') border-red-400 @enderror">
                </div>
            </div>

            {{-- Location + Status --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Location / Wing</label>
                    <input type="text" name="location" value="{{ old('location') }}"
                           placeholder="e.g. Floor 2, Block B"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium @error('location') border-red-400 @enderror">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Status <span class="text-red-500">*</span></label>
                    <select name="status" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium appearance-none @error('status') border-red-400 @enderror">
                        <option value="active"   {{ old('status', 'active') === 'active'   ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('modules.departments.index') }}"
                   class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white rounded-xl shadow-md shadow-blue-500/20 transition-all hover:opacity-90 hover:scale-[1.02]"
                        style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Create Department
                </button>
            </div>
        </form>
    </div>
</div>
</x-admin-layout>
