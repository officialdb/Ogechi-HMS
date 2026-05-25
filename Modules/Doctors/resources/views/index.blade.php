<x-admin-layout title="Doctors">
<div class="space-y-6">
    
    {{-- ── HEADER ─────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Doctors Registry</h1>
            <p class="text-sm text-slate-500 mt-1">Manage hospital physicians and specialists</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('modules.doctors.create') }}" class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Register Doctor
            </a>
        </div>
    </div>

    {{-- ── FILTER / SEARCH BAR ────────────────────────── --}}
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col sm:flex-row gap-4 items-center justify-between">
        <form method="GET" action="{{ route('modules.doctors.index') }}" class="flex-1 w-full sm:w-auto relative" id="search-form">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Search doctors by name, specialty, or license…" 
                   class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
        </form>
        <div class="flex items-center gap-2 w-full sm:w-auto overflow-x-auto pb-1 sm:pb-0 hide-scrollbar">
            @foreach(['all'=>'All','active'=>'Active','inactive'=>'Inactive','on_leave'=>'On Leave'] as $val => $label)
                @php $isActive = request('status', 'all') === $val; @endphp
                <a href="{{ request()->fullUrlWithQuery(['status' => $val, 'page' => 1]) }}" 
                   class="whitespace-nowrap px-4 py-2 text-xs font-bold rounded-xl transition-colors border {{ $isActive ? 'bg-blue-50 text-blue-700 border-blue-200' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- ── DATA GRID ──────────────────────────────────── --}}
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden relative">
        
        {{-- Skeleton overlay (shown briefly on load) --}}
        <div x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 800)">
            <div x-show="loading" x-transition.opacity class="absolute inset-0 bg-white z-10 p-5">
                <div class="space-y-4">
                    <div class="skeleton h-10 w-full rounded-xl"></div>
                    @for($i=0; $i<5; $i++)
                        <div class="skeleton h-16 w-full rounded-xl"></div>
                    @endfor
                </div>
            </div>
            
            @if($doctors->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-500 font-semibold text-xs tracking-wide uppercase">
                                <th class="px-6 py-4">Doctor</th>
                                <th class="px-6 py-4">Specialization</th>
                                <th class="px-6 py-4">Contact</th>
                                <th class="px-6 py-4">License No.</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-slate-700">
                            @foreach($doctors as $doctor)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-6 py-3.5">
                                        <div class="flex items-center gap-3">
                                            @php
                                                $initials = strtoupper(substr($doctor->first_name,0,1).substr($doctor->last_name,0,1));
                                                $gradients = ['from-blue-500 to-blue-700','from-violet-500 to-purple-700','from-emerald-500 to-teal-700'];
                                                $grad = $gradients[$doctor->id % 3];
                                            @endphp
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $grad }} text-white font-bold flex items-center justify-center flex-shrink-0 shadow-sm">
                                                {{ $initials }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-900 group-hover:text-blue-600 transition-colors">{{ $doctor->full_name }}</p>
                                                <p class="text-[11px] text-slate-500 mt-0.5">Joined {{ $doctor->created_at->format('M Y') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3.5">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700">
                                            {{ $doctor->specialization }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3.5">
                                        <div class="text-xs">
                                            <p class="font-medium text-slate-700">{{ $doctor->phone }}</p>
                                            <p class="text-slate-400 mt-0.5">{{ $doctor->email ?? '—' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3.5">
                                        <span class="font-mono text-xs text-slate-500">{{ $doctor->license_number }}</span>
                                    </td>
                                    <td class="px-6 py-3.5">
                                        @if($doctor->status === 'active')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100/50">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                            </span>
                                        @elseif($doctor->status === 'on_leave')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100/50">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> On Leave
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200/50">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3.5 text-right">
                                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('modules.doctors.show', $doctor) }}" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors" title="View Profile">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            <a href="{{ route('modules.doctors.edit', $doctor) }}" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center hover:bg-slate-200 transition-colors" title="Edit Doctor">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                @if($doctors->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $doctors->links() }}
                    </div>
                @endif
            @else
                <div class="py-16 px-6 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 mb-1">No Doctors Found</h3>
                    <p class="text-xs text-slate-500 mb-4 max-w-sm mx-auto">There are no doctors registered yet or matching your search criteria. Add your first doctor to get started.</p>
                    <a href="{{ route('modules.doctors.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                        Register Doctor
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
</x-admin-layout>
