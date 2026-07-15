<x-admin-layout title="Laboratory Tests">
<div class="space-y-6">
    
    {{-- ── HEADER ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Laboratory</h1>
            <p class="text-sm text-slate-500 mt-0.5">Manage and track patient lab tests and results.</p>
        </div>
        <a href="{{ route('modules.laboratory.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90 hover:scale-[1.02]" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
            <x-fas-calendar-alt class="w-4 h-4" />
            New Lab Test
        </a>
    </div>

    {{-- ── STATS ── --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach([
            ['label'=>'Total Tests', 'val'=>$stats['total'], 'color'=>'text-blue-600', 'bg'=>'bg-blue-50', 'icon'=>'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'],
            ['label'=>'Pending', 'val'=>$stats['pending'], 'color'=>'text-amber-500', 'bg'=>'bg-amber-50', 'icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label'=>'Processing', 'val'=>$stats['processing'], 'color'=>'text-teal-500', 'bg'=>'bg-teal-50', 'icon'=>'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'],
            ['label'=>'Completed', 'val'=>$stats['completed'], 'color'=>'text-emerald-500', 'bg'=>'bg-emerald-50', 'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ] as $stat)
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-100 shadow-sm flex items-center gap-4">
                <div class="{{ $stat['bg'] }} w-12 h-12 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <x-fas-flask class="w-6 h-6 sm:w-7 sm:h-7 {{ $stat['color'] }}" />
                </div>
                <div>
                    <p class="text-xl sm:text-2xl font-black text-slate-900 leading-none">{{ number_format($stat['val']) }}</p>
                    <p class="text-xs sm:text-sm font-semibold text-slate-500 mt-1">{{ $stat['label'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ── FILTERS & LIST ── --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        {{-- Toolbar --}}
        <div class="p-4 sm:p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <form action="{{ route('modules.laboratory.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <x-fas-plus class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Search tests or patients..." class="w-full pl-9 pr-4 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                </div>
                <select name="status" class="py-2 pl-3 pr-8 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors appearance-none">
                    <option value="all">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Filter</button>
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 text-[11px] font-bold tracking-wider text-slate-400 uppercase">Patient & Doctor</th>
                        <th class="px-6 py-4 text-[11px] font-bold tracking-wider text-slate-400 uppercase">Test Details</th>
                        <th class="px-6 py-4 text-[11px] font-bold tracking-wider text-slate-400 uppercase">Cost</th>
                        <th class="px-6 py-4 text-[11px] font-bold tracking-wider text-slate-400 uppercase">Status</th>
                        <th class="px-6 py-4 text-[11px] font-bold tracking-wider text-slate-400 uppercase text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tests as $test)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="font-bold text-sm text-slate-800">{{ $test->patient->first_name }} {{ $test->patient->last_name }}</div>
                                <div class="text-xs font-medium text-slate-500">{{ $test->doctor ? 'Dr. ' . $test->doctor->last_name : 'No Doctor Assigned' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-sm text-slate-800">{{ $test->test_name }}</div>
                                <div class="text-xs font-medium text-slate-500 uppercase tracking-wider">{{ $test->test_type }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-sm text-slate-800">{{ $currency_symbol }}{{ number_format($test->cost, 2) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $sColors = [
                                        'pending'    => 'bg-amber-50 text-amber-700 border-amber-100',
                                        'processing' => 'bg-teal-50 text-teal-700 border-teal-100',
                                        'completed'  => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                        'cancelled'  => 'bg-slate-50 text-slate-700 border-slate-200',
                                    ];
                                    $sColor = $sColors[$test->status] ?? $sColors['pending'];
                                    
                                    $sDotColors = [
                                        'pending'    => 'bg-amber-500',
                                        'processing' => 'bg-teal-500',
                                        'completed'  => 'bg-emerald-500',
                                        'cancelled'  => 'bg-slate-400',
                                    ];
                                    $sDotColor = $sDotColors[$test->status] ?? $sDotColors['pending'];
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold border {{ $sColor }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $sDotColor }}"></span>
                                    {{ ucfirst($test->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('modules.laboratory.edit', $test) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                    <x-fas-flask class="w-5 h-5" />
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-100">
                                    <x-fas-flask class="w-8 h-8 text-slate-400" />
                                </div>
                                <h3 class="text-sm font-bold text-slate-900 mb-1">No lab tests found</h3>
                                <p class="text-sm text-slate-500">There are no lab tests matching your criteria.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        @if($tests->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $tests->links() }}
            </div>
        @endif
    </div>
</div>
</x-admin-layout>
