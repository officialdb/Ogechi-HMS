<x-admin-layout title="Pharmacy Inventory">
<div class="space-y-6">
    
    {{-- ── HEADER ─────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Pharmacy Inventory</h1>
            <p class="text-sm text-slate-500 mt-1">Manage hospital medications and stock levels</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('modules.pharmacy.create') }}" class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                <x-fas-calendar-alt class="w-5 h-5" />
                Add Medication
            </a>
        </div>
    </div>

    {{-- ── FILTER / SEARCH BAR ────────────────────────── --}}
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col sm:flex-row gap-4 items-center justify-between">
        <form method="GET" action="{{ route('modules.pharmacy.index') }}" class="flex-1 w-full sm:w-auto relative" id="search-form">
            <x-fas-plus class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Search by name, generic name, or category…" 
                   class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
        </form>
        <div class="flex items-center gap-2 w-full sm:w-auto overflow-x-auto pb-1 sm:pb-0 hide-scrollbar">
            @foreach(['all'=>'All Stock','available'=>'Available','low_stock'=>'Low Stock','out_of_stock'=>'Out of Stock','expired'=>'Expired'] as $val => $label)
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
        
        {{-- Skeleton overlay --}}
        <div x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 800)">
            <div x-show="loading" x-transition.opacity class="absolute inset-0 bg-white z-10 p-5">
                <div class="space-y-4">
                    <div class="skeleton h-10 w-full rounded-xl"></div>
                    @for($i=0; $i<5; $i++)
                        <div class="skeleton h-16 w-full rounded-xl"></div>
                    @endfor
                </div>
            </div>
            
            @if($medications->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-500 font-semibold text-xs tracking-wide uppercase">
                                <th class="px-6 py-4">Medication</th>
                                <th class="px-6 py-4">Category</th>
                                <th class="px-6 py-4">Stock & Price</th>
                                <th class="px-6 py-4">Expiry</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-slate-700">
                            @foreach($medications as $med)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-6 py-3.5">
                                        <p class="font-bold text-slate-900 group-hover:text-blue-600 transition-colors">{{ $med->name }}</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5">{{ $med->generic_name ?: 'No generic name' }}</p>
                                    </td>
                                    <td class="px-6 py-3.5">
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200 uppercase tracking-wider">
                                            {{ $med->category }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3.5">
                                        <p class="font-bold {{ $med->quantity_in_stock <= 20 ? 'text-amber-600' : 'text-slate-700' }}">{{ $med->quantity_in_stock }} Units</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5">{{ $currency_symbol }}{{ number_format($med->unit_price, 2) }} / unit</p>
                                    </td>
                                    <td class="px-6 py-3.5">
                                        @if($med->expiry_date)
                                            <p class="font-semibold {{ \Carbon\Carbon::parse($med->expiry_date)->isPast() ? 'text-red-600' : 'text-slate-700' }}">
                                                {{ \Carbon\Carbon::parse($med->expiry_date)->format('M d, Y') }}
                                            </p>
                                        @else
                                            <p class="text-slate-400 italic">N/A</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3.5">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-{{ $med->status_color }}-50 text-{{ $med->status_color }}-700 border border-{{ $med->status_color }}-100/50 uppercase tracking-wider">
                                            <span class="w-1.5 h-1.5 rounded-full bg-{{ $med->status_color }}-500"></span> 
                                            {{ str_replace('_', ' ', $med->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3.5 text-right">
                                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('modules.pharmacy.edit', $med) }}" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center hover:bg-slate-200 transition-colors" title="Edit / Restock">
                                                <x-fas-tachometer-alt class="w-4 h-4" />
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                @if($medications->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $medications->links() }}
                    </div>
                @endif
            @else
                <div class="py-16 px-6 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-100">
                        <x-fas-pills class="w-8 h-8 text-slate-300" />
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 mb-1">No Inventory Found</h3>
                    <p class="text-xs text-slate-500 mb-4 max-w-sm mx-auto">There are no medications matching your search criteria. Add stock to get started.</p>
                    <a href="{{ route('modules.pharmacy.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                        Add Medication
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
</x-admin-layout>
