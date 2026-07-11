<x-admin-layout title="Departments">
<div class="max-w-7xl mx-auto space-y-6">

    {{-- ── HEADER ──────────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Departments</h1>
            <p class="text-sm text-slate-500 mt-1">Manage hospital departments and their leadership.</p>
        </div>
        <a href="{{ route('modules.departments.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white rounded-xl shadow-md shadow-blue-500/20 transition-all hover:opacity-90 hover:scale-[1.02]"
           style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
            <x-fas-calendar-alt class="w-4 h-4" />
            New Department
        </a>
    </div>

    {{-- ── FLASH MESSAGE ────────────────────────────────────── --}}
    @if(session('success'))
        <div class="flex items-center gap-3 px-5 py-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-sm font-semibold shadow-sm">
            <x-fas-plus class="w-5 h-5 text-emerald-500 shrink-0" />
            {{ session('success') }}
        </div>
    @endif

    {{-- ── STAT CARDS ──────────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        {{-- Total --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0" style="background:linear-gradient(135deg,#EFF6FF,#DBEAFE);">
                <x-fas-tachometer-alt class="w-6 h-6 text-blue-600" />
            </div>
            <div>
                <p class="text-2xl font-black text-slate-900">{{ $stats['total'] }}</p>
                <p class="text-xs font-semibold text-slate-500 mt-0.5">Total Departments</p>
            </div>
        </div>
        {{-- Active --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0" style="background:linear-gradient(135deg,#F0FDF4,#DCFCE7);">
                <x-fas-plus class="w-6 h-6 text-emerald-600" />
            </div>
            <div>
                <p class="text-2xl font-black text-slate-900">{{ $stats['active'] }}</p>
                <p class="text-xs font-semibold text-slate-500 mt-0.5">Active</p>
            </div>
        </div>
        {{-- Inactive --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0" style="background:linear-gradient(135deg,#F8FAFC,#F1F5F9);">
                <x-fas-plus class="w-6 h-6 text-slate-400" />
            </div>
            <div>
                <p class="text-2xl font-black text-slate-900">{{ $stats['inactive'] }}</p>
                <p class="text-xs font-semibold text-slate-500 mt-0.5">Inactive</p>
            </div>
        </div>
    </div>

    {{-- ── FILTERS ──────────────────────────────────────────── --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
        <form method="GET" action="{{ route('modules.departments.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <x-fas-plus class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search departments, heads, locations…"
                       class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
            </div>
            <select name="status" class="px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors appearance-none">
                <option value="">All Statuses</option>
                <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white rounded-xl transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                Filter
            </button>
            @if(request('search') || request('status'))
                <a href="{{ route('modules.departments.index') }}" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors text-center">
                    Clear
                </a>
            @endif
        </form>
    </div>

    {{-- ── TABLE ────────────────────────────────────────────── --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        @if($departments->count())
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/70">
                        <th class="text-left px-6 py-3.5 text-xs font-black text-slate-500 uppercase tracking-wider">Department</th>
                        <th class="text-left px-6 py-3.5 text-xs font-black text-slate-500 uppercase tracking-wider">Head of Department</th>
                        <th class="text-left px-6 py-3.5 text-xs font-black text-slate-500 uppercase tracking-wider">Location</th>
                        <th class="text-left px-6 py-3.5 text-xs font-black text-slate-500 uppercase tracking-wider">Doctors</th>
                        <th class="text-left px-6 py-3.5 text-xs font-black text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="text-right px-6 py-3.5 text-xs font-black text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($departments as $dept)
                    <tr class="hover:bg-slate-50/60 transition-colors group">
                        {{-- Name + Description --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 text-blue-600 font-black text-sm" style="background:linear-gradient(135deg,#EFF6FF,#DBEAFE);">
                                    {{ strtoupper(substr($dept->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900">{{ $dept->name }}</p>
                                    @if($dept->description)
                                        <p class="text-xs text-slate-400 mt-0.5 line-clamp-1">{{ $dept->description }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        {{-- Head --}}
                        <td class="px-6 py-4 text-slate-600 font-medium">
                            {{ $dept->head_of_department ?: '—' }}
                        </td>
                        {{-- Location --}}
                        <td class="px-6 py-4 text-slate-500">
                            {{ $dept->location ?: '—' }}
                        </td>
                        {{-- Doctors count --}}
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700">
                                <x-fas-tachometer-alt class="w-3.5 h-3.5" />
                                {{ $dept->doctors_count }}
                            </span>
                        </td>
                        {{-- Status --}}
                        <td class="px-6 py-4">
                            @if($dept->status === 'active')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Inactive
                                </span>
                            @endif
                        </td>
                        {{-- Actions --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('modules.departments.edit', $dept) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-blue-700 bg-blue-50 border border-blue-100 rounded-lg hover:bg-blue-100 transition-colors">
                                    <x-fas-tachometer-alt class="w-3.5 h-3.5" />
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('modules.departments.destroy', $dept) }}" onsubmit="return confirm('Delete this department? Doctors assigned to it will be unassigned.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-red-700 bg-red-50 border border-red-100 rounded-lg hover:bg-red-100 transition-colors">
                                        <x-fas-plus class="w-3.5 h-3.5" />
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($departments->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $departments->links() }}
            </div>
        @endif

        @else
        {{-- Empty state --}}
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4" style="background:linear-gradient(135deg,#EFF6FF,#DBEAFE);">
                <x-fas-tachometer-alt class="w-8 h-8 text-blue-500" />
            </div>
            <p class="text-lg font-black text-slate-700 mb-1">No departments yet</p>
            <p class="text-sm text-slate-400 mb-6">Create your first department to get started.</p>
            <a href="{{ route('modules.departments.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white rounded-xl" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                <x-fas-calendar-alt class="w-4 h-4" />
                New Department
            </a>
        </div>
        @endif
    </div>

</div>
</x-admin-layout>
