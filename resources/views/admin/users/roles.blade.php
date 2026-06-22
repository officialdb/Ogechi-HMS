<x-admin-layout title="Manage Roles - {{ $user->name }}">
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Breadcrumb & Header --}}
    <div>
        <div class="flex items-center gap-2 text-xs text-slate-400 mb-3">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.users.index') }}" class="hover:text-blue-600 transition-colors">Users</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-slate-600 font-semibold">{{ $user->name }}</span>
        </div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Manage Roles</h1>
        <p class="text-sm text-slate-500 mt-1">Assign or remove roles for <span class="font-bold text-slate-700">{{ $user->name }}</span></p>
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

    <form method="POST" action="{{ route('admin.users.roles.update', $user) }}" class="bg-white border border-slate-100 shadow-sm rounded-2xl overflow-hidden">
        @csrf
        @method('PUT')
        
        <div class="p-6 sm:p-8">
            <h3 class="text-sm font-bold text-slate-800 mb-4">Available Roles</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($roles as $role)
                    @php $hasRole = $user->hasRole($role->name); @endphp
                    <label class="flex items-start gap-3 p-4 rounded-xl border {{ $hasRole ? 'border-blue-500 bg-blue-50/30' : 'border-slate-200 bg-white hover:border-blue-300 hover:bg-slate-50' }} transition-colors cursor-pointer">
                        <div class="pt-0.5">
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}" {{ $hasRole ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500">
                        </div>
                        <div>
                            <p class="text-sm font-bold {{ $hasRole ? 'text-blue-900' : 'text-slate-800' }}">{{ $role->name }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">Grants specific permissions for the {{ strtolower($role->name) }} area.</p>
                        </div>
                    </label>
                @endforeach
            </div>
            
            @if($user->hasRole('Super Admin'))
                <div class="mt-6 p-4 rounded-xl bg-amber-50 border border-amber-200">
                    <p class="text-xs font-bold text-amber-800">Note: This user is a Super Admin.</p>
                    <p class="text-[11px] text-amber-700 mt-0.5">The Super Admin role cannot be removed from this interface to prevent locking out administrators.</p>
                </div>
            @endif
        </div>
        
        <div class="px-6 sm:px-8 py-5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200 hover:bg-slate-100 rounded-xl transition-colors">Cancel</a>
            <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                Save Roles
            </button>
        </div>
    </form>

</div>
</x-admin-layout>
