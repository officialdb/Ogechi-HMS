<x-admin-layout title="Patients">
<div class="space-y-5" x-data="{ loading: true, view: 'table' }" x-init="setTimeout(() => loading = false, 1500)">

    {{-- ── PAGE HEADING ─────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('dashboard') }}" class="text-xs text-slate-400 hover:text-blue-600 transition-colors">Dashboard</a>
                <x-fas-chevron-right class="w-3 h-3 text-slate-300" />
                <span class="text-xs text-blue-600 font-semibold">Patients</span>
            </div>
            <h1 class="text-xl font-bold text-slate-900">Patient Registry</h1>
            <p class="text-sm text-slate-500 mt-0.5">Manage all patient records, demographics and medical history.</p>
        </div>
        <div class="flex items-center gap-2">
            {{-- View toggle --}}
            <div class="flex items-center bg-white border border-slate-200 rounded-xl p-1 shadow-sm">
                <button @click="view='table'" :class="view==='table' ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-400 hover:text-slate-600'"
                        class="p-2 rounded-lg transition-all duration-150">
                    <x-fas-list class="w-4 h-4" />
                </button>
                <button @click="view='grid'" :class="view==='grid' ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-400 hover:text-slate-600'"
                        class="p-2 rounded-lg transition-all duration-150">
                    <x-fas-th-large class="w-4 h-4" />
                </button>
            </div>
            @can('patients.create')
                <a href="{{ route('patients.create') }}"
                   class="flex items-center gap-2 px-4 py-2.5 text-white text-sm font-bold rounded-xl transition-all duration-200 hover:opacity-90 hover:shadow-lg shadow-md"
                   style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                    <x-fas-calendar-alt class="w-4 h-4" />
                    Register Patient
                </a>
            @endcan
        </div>
    </div>

    {{-- ── STAT CARDS ────────────────────────────────────── --}}
    <div x-show="loading" class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @for($i=0;$i<4;$i++)
            <div class="bg-white rounded-2xl p-5 border border-slate-100 flex items-center gap-4">
                <div class="skeleton w-12 h-12 rounded-xl flex-shrink-0"></div>
                <div class="space-y-2 flex-1"><div class="skeleton h-6 w-16"></div><div class="skeleton h-3 w-24"></div></div>
            </div>
        @endfor
    </div>

    <div x-show="!loading" x-transition class="grid grid-cols-2 lg:grid-cols-4 gap-4" style="display:none;">
        @php
            $miniStats = [
                ['label'=>'Total Patients','value'=>number_format($stats['total'] ?? 0),'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z','bg'=>'bg-blue-50','color'=>'text-blue-600','delta'=>'All records'],
                ['label'=>'Admitted Today','value'=>number_format($stats['admitted_today'] ?? 0),'icon'=>'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z','bg'=>'bg-rose-50','color'=>'text-rose-500','delta'=>'Today\'s admissions'],
                ['label'=>'Outpatients','value'=>number_format($stats['outpatients'] ?? 0),'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2','bg'=>'bg-emerald-50','color'=>'text-emerald-600','delta'=>'Active today'],
                ['label'=>'Discharged','value'=>number_format($stats['discharged'] ?? 0),'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z','bg'=>'bg-violet-50','color'=>'text-violet-600','delta'=>'Recent records'],
            ];
        @endphp
        @foreach($miniStats as $s)
            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-4">
                <div class="{{ $s['bg'] }} w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 {{ $s['color'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/></svg>
                </div>
                <div>
                    <p class="text-xl font-black text-slate-900">{{ $s['value'] }}</p>
                    <p class="text-[11px] font-semibold text-slate-500 mt-0.5">{{ $s['label'] }}</p>
                    <p class="text-[10px] text-emerald-600 font-medium mt-0.5">{{ $s['delta'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ── SEARCH & FILTER BAR ───────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
        <form method="GET" action="{{ route('patients.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <x-fas-plus class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                <input name="search" type="search" value="{{ $search }}"
                       placeholder="Search by name, patient number, phone or email…"
                       class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
            </div>
            <select name="gender" class="text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400">
                <option value="">All Genders</option>
                <option value="male" {{ request('gender')=='male'?'selected':'' }}>Male</option>
                <option value="female" {{ request('gender')=='female'?'selected':'' }}>Female</option>
            </select>
            <div class="flex gap-2">
                <button type="submit" class="px-5 py-2.5 text-white text-sm font-bold rounded-xl transition-all hover:opacity-90 shadow-sm" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                    Search
                </button>
                <a href="{{ route('patients.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold rounded-xl transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- ── FLASH STATUS ─────────────────────────────────── --}}
    @if(session('status'))
        <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 rounded-2xl px-5 py-3.5 text-sm font-medium text-emerald-800">
            <x-fas-plus class="w-5 h-5 text-emerald-600 flex-shrink-0" />
            {{ session('status') }}
        </div>
    @endif

    {{-- ── SKELETON TABLE ──────────────────────────────── --}}
    <div x-show="loading" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="flex justify-between px-6 pt-5 pb-4 border-b border-slate-100">
            <div class="skeleton h-4 w-32"></div><div class="skeleton h-4 w-16"></div>
        </div>
        @for($i=0;$i<6;$i++)
            <div class="flex items-center gap-4 px-6 py-4 border-b border-slate-50">
                <div class="skeleton w-9 h-9 rounded-xl flex-shrink-0"></div>
                <div class="flex-1 space-y-2"><div class="skeleton h-3.5 w-40"></div><div class="skeleton h-3 w-24"></div></div>
                <div class="skeleton h-6 w-20 rounded-full hidden sm:block"></div>
                <div class="skeleton h-3 w-28 hidden md:block"></div>
                <div class="skeleton h-3 w-24 hidden lg:block"></div>
                <div class="skeleton h-7 w-16 rounded-lg"></div>
            </div>
        @endfor
    </div>

    {{-- ── TABLE VIEW ──────────────────────────────────── --}}
    <div x-show="!loading && view==='table'" x-transition class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" style="display:none;">
        <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-slate-100">
            <div>
                <h2 class="text-sm font-bold text-slate-800">All Patients</h2>
                <p class="text-xs text-slate-400 mt-0.5">{{ number_format($patients->total()) }} records found</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-400">Page {{ $patients->currentPage() }} of {{ $patients->lastPage() }}</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Patient</th>
                        <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Patient ID</th>
                        <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider hidden sm:table-cell">Contact</th>
                        <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider hidden md:table-cell">Blood / Genotype</th>
                        <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider hidden lg:table-cell">Registered</th>
                        <th class="px-4 py-3.5 text-right text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($patients as $patient)
                        @php
                            $initials = strtoupper(substr($patient->first_name,0,1).substr($patient->last_name,0,1));
                            $colors = ['from-blue-400 to-blue-600','from-violet-400 to-purple-600','from-rose-400 to-rose-600','from-emerald-400 to-teal-600','from-amber-400 to-orange-500'];
                            $color = $colors[$patient->id % 5];
                        @endphp
                        <tr class="hover:bg-blue-50/20 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br {{ $color }} text-white font-bold text-xs flex items-center justify-center shadow-sm flex-shrink-0">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">{{ $patient->full_name }}</p>
                                        <p class="text-[11px] text-slate-400 capitalize mt-0.5">{{ $patient->gender }} · {{ $patient->date_of_birth?->age ?? '—' }}y</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-blue-50 text-blue-700">
                                    {{ $patient->patient_number ?? 'Pending' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 hidden sm:table-cell">
                                <p class="text-xs font-medium text-slate-700">{{ $patient->phone }}</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">{{ $patient->email ?: 'No email' }}</p>
                            </td>
                            <td class="px-4 py-4 hidden md:table-cell">
                                <div class="flex items-center gap-2">
                                    @if($patient->blood_group)
                                        <span class="px-2 py-0.5 rounded-lg text-[11px] font-bold bg-red-50 text-red-600">{{ $patient->blood_group }}</span>
                                    @endif
                                    @if($patient->genotype)
                                        <span class="px-2 py-0.5 rounded-lg text-[11px] font-bold bg-amber-50 text-amber-700">{{ $patient->genotype }}</span>
                                    @endif
                                    @if(!$patient->blood_group && !$patient->genotype)
                                        <span class="text-xs text-slate-400">Not recorded</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-4 hidden lg:table-cell">
                                <p class="text-xs text-slate-700">{{ $patient->created_at->format('M d, Y') }}</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">{{ $patient->registeredBy?->name ?? 'System' }}</p>
                                @if($patient->assignedDoctor)
                                    <span class="inline-flex items-center gap-1 mt-1 px-1.5 py-0.5 rounded-md text-[10px] font-semibold bg-blue-50 text-blue-700">
                                        <x-fas-user-md class="w-2.5 h-2.5" />
                                        {{ $patient->assignedDoctor->full_name }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center justify-end gap-1.5 opacity-60 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('patients.show', $patient) }}"
                                       class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-lg text-xs font-bold transition-colors">
                                        <x-fas-eye class="w-3.5 h-3.5" />
                                        View
                                    </a>
                                    @can('patients.update')
                                        <a href="{{ route('patients.edit', $patient) }}"
                                           class="w-8 h-8 bg-slate-100 text-slate-500 hover:bg-amber-500 hover:text-white rounded-lg flex items-center justify-center transition-colors">
                                            <x-fas-pen class="w-3.5 h-3.5" />
                                        </a>
                                    @endcan
                                    @can('patients.delete')
                                        <form method="POST" action="{{ route('patients.destroy', $patient) }}"
                                              x-data x-on:submit.prevent="confirm('Archive {{ addslashes($patient->full_name) }}?') && $el.submit()">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-8 h-8 bg-slate-100 text-slate-500 hover:bg-red-500 hover:text-white rounded-lg flex items-center justify-center transition-colors">
                                                <x-fas-trash class="w-3.5 h-3.5" />
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <x-fas-folder-open class="w-8 h-8 text-blue-400" />
                                </div>
                                <p class="text-base font-bold text-slate-800">No patients found</p>
                                <p class="text-sm text-slate-400 mt-1 mb-4">{{ $search ? 'Try adjusting your search.' : 'Register the first patient to get started.' }}</p>
                                @can('patients.create')
                                    <a href="{{ route('patients.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-white text-sm font-bold rounded-xl shadow-md" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                                        <x-fas-calendar-alt class="w-4 h-4" />
                                        Register First Patient
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($patients->hasPages())
            <div class="border-t border-slate-100 px-6 py-4 flex items-center justify-between">
                <p class="text-xs text-slate-400">
                    Showing {{ $patients->firstItem() }}–{{ $patients->lastItem() }} of {{ number_format($patients->total()) }} patients
                </p>
                {{ $patients->links() }}
            </div>
        @endif
    </div>

    {{-- ── GRID VIEW ────────────────────────────────────── --}}
    <div x-show="!loading && view==='grid'" x-transition class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" style="display:none;">
        @forelse($patients as $patient)
            @php
                $initials = strtoupper(substr($patient->first_name,0,1).substr($patient->last_name,0,1));
                $colors = ['from-blue-400 to-blue-600','from-violet-400 to-purple-600','from-rose-400 to-rose-600','from-emerald-400 to-teal-600','from-amber-400 to-orange-500'];
                $color = $colors[$patient->id % 5];
            @endphp
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 overflow-hidden group">
                <div class="h-16 bg-gradient-to-br {{ $color }} relative">
                    <div class="absolute -bottom-6 left-5 w-12 h-12 rounded-2xl bg-white shadow-lg flex items-center justify-center">
                        <span class="font-black text-sm bg-gradient-to-br {{ $color }} bg-clip-text text-transparent">{{ $initials }}</span>
                    </div>
                </div>
                <div class="pt-9 px-5 pb-5">
                    <h3 class="text-sm font-bold text-slate-900 truncate">{{ $patient->full_name }}</h3>
                    <p class="text-[11px] text-slate-400 capitalize mt-0.5">{{ $patient->gender }} · {{ $patient->date_of_birth?->age ?? '—' }}y</p>
                    <div class="flex items-center gap-1.5 mt-2.5">
                        <span class="px-2 py-0.5 text-[10px] font-bold bg-blue-50 text-blue-700 rounded-lg">{{ $patient->patient_number ?? 'Pending' }}</span>
                        @if($patient->blood_group) <span class="px-2 py-0.5 text-[10px] font-bold bg-red-50 text-red-600 rounded-lg">{{ $patient->blood_group }}</span> @endif
                    </div>
                    <p class="text-xs text-slate-500 mt-3 truncate">
                        <x-fas-phone class="w-3 h-3 inline mr-1 text-slate-400" />
                        {{ $patient->phone }}
                    </p>
                    <div class="flex items-center gap-2 mt-4 pt-4 border-t border-slate-100">
                        <a href="{{ route('patients.show', $patient) }}" class="flex-1 text-center text-xs font-bold py-2 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">View</a>
                        @can('patients.update')
                            <a href="{{ route('patients.edit', $patient) }}" class="flex-1 text-center text-xs font-bold py-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 transition-colors">Edit</a>
                        @endcan
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center">
                <p class="text-base font-bold text-slate-800">No patients found.</p>
            </div>
        @endforelse

        @if($patients->hasPages())
            <div class="col-span-full mt-2">{{ $patients->links() }}</div>
        @endif
    </div>

</div>
</x-admin-layout>
