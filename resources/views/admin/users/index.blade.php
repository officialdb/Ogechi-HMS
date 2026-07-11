<x-admin-layout title="User Management">
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">User Management</h1>
            <p class="text-sm text-slate-500 mt-1">Manage system users and their assigned roles</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl text-sm font-medium border border-emerald-100">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter/Search --}}
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex gap-4 items-center">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex-1 w-full max-w-sm relative">
            <x-fas-plus class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Search users by name or email…" 
                   class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors">
        </form>
    </div>

    {{-- Data Grid --}}
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
        @if($users->count())
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-500 font-semibold text-xs tracking-wide uppercase">
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4">Roles</th>
                            <th class="px-6 py-4">Joined Date</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-slate-700">
                        @foreach($users as $user)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold shadow-sm flex-shrink-0" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900">{{ $user->name }}</p>
                                            <p class="text-[11px] text-slate-500 mt-0.5">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3.5">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse($user->roles as $role)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                                {{ $role->name }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-slate-400">No Roles</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-6 py-3.5">
                                    <p class="text-xs text-slate-500 font-medium">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </p>
                                </td>
                                <td class="px-6 py-3.5 text-right">
                                    <a href="{{ route('admin.users.roles', $user) }}" class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-bold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors border border-blue-100">
                                        Manage Roles
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $users->links() }}
                </div>
            @endif
        @else
            <div class="py-16 px-6 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-100">
                    <x-fas-search class="w-8 h-8 text-slate-300" />
                </div>
                <h3 class="text-sm font-bold text-slate-900 mb-1">No Users Found</h3>
                <p class="text-xs text-slate-500 mb-4 max-w-sm mx-auto">There are no users matching your criteria.</p>
            </div>
        @endif
    </div>

</div>
</x-admin-layout>
