<x-admin-layout title="Edit Department">
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('modules.departments.index') }}"
           class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-colors shadow-sm">
            <x-fas-eye class="w-4 h-4" />
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Edit Department</h1>
            <p class="text-sm text-slate-500 mt-0.5">Updating: <span class="font-bold text-slate-700">{{ $dept->name }}</span></p>
        </div>
    </div>

    {{-- Form --}}
    <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm">
        <form action="{{ route('modules.departments.update', $dept) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Validation errors --}}
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-2xl p-4 text-sm text-red-700 space-y-1">
                    @foreach($errors->all() as $error)
                        <p class="flex items-center gap-2"><x-fas-eye class="w-4 h-4 shrink-0" />{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            {{-- Name --}}
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Department Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $dept->name) }}" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium @error('name') border-red-400 bg-red-50 @enderror">
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                <textarea name="description" rows="3"
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium resize-none @error('description') border-red-400 bg-red-50 @enderror">{{ old('description', $dept->description) }}</textarea>
            </div>

            {{-- Head + Phone --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Head of Department</label>
                    <input type="text" name="head_of_department" value="{{ old('head_of_department', $dept->head_of_department) }}"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Department Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $dept->phone) }}"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium">
                </div>
            </div>

            {{-- Location + Status --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Location / Wing</label>
                    <input type="text" name="location" value="{{ old('location', $dept->location) }}"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Status <span class="text-red-500">*</span></label>
                    <select name="status" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-slate-900 font-medium appearance-none">
                        <option value="active"   {{ old('status', $dept->status) === 'active'   ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $dept->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            {{-- Info: linked doctors --}}
            @if($dept->doctors_count ?? $dept->doctors()->count())
                <div class="flex items-start gap-3 bg-blue-50 border border-blue-100 rounded-2xl p-4 text-sm text-blue-800">
                    <x-fas-eye class="w-5 h-5 shrink-0 mt-0.5 text-blue-500" />
                    <p>This department currently has <strong>{{ $dept->doctors()->count() }} doctor(s)</strong> assigned to it.</p>
                </div>
            @endif

            {{-- Buttons --}}
            <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                {{-- Delete --}}
                <form method="POST" action="{{ route('modules.departments.destroy', $dept) }}"
                      onsubmit="return confirm('Are you sure you want to delete this department? Doctors assigned will be unassigned.')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-bold text-red-700 bg-red-50 border border-red-200 rounded-xl hover:bg-red-100 transition-colors">
                        <x-fas-plus class="w-4 h-4" />
                        Delete
                    </button>
                </form>

                <div class="flex items-center gap-3">
                    <a href="{{ route('modules.departments.index') }}"
                       class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white rounded-xl shadow-md shadow-blue-500/20 transition-all hover:opacity-90 hover:scale-[1.02]"
                            style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                        <x-fas-eye class="w-4 h-4" />
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
</x-admin-layout>
