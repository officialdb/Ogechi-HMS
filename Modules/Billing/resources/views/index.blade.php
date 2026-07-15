<x-admin-layout title="Billing & Invoices">
<div class="space-y-6">
    
    {{-- ── HEADER ─────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Billing & Invoices</h1>
            <p class="text-sm text-slate-500 mt-1">Manage patient billing and hospital revenue.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('modules.billing.create') }}" class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                <x-fas-file-invoice-dollar class="w-5 h-5" />
                Create Invoice
            </a>
        </div>
    </div>

    {{-- ── METRICS DASHBOARD (Placeholder logic) ─────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Revenue</p>
            <p class="text-2xl font-black text-emerald-600">{{ $currency_symbol }}{{ number_format(\Modules\Billing\Models\Invoice::where('status', 'paid')->sum('total_amount'), 2) }}</p>
        </div>
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Pending Unpaid</p>
            <p class="text-2xl font-black text-amber-600">{{ $currency_symbol }}{{ number_format(\Modules\Billing\Models\Invoice::where('status', 'pending')->sum('total_amount'), 2) }}</p>
        </div>
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Overdue Amount</p>
            <p class="text-2xl font-black text-red-600">{{ $currency_symbol }}{{ number_format(\Modules\Billing\Models\Invoice::where('status', 'overdue')->sum('total_amount'), 2) }}</p>
        </div>
    </div>

    {{-- ── FILTER / SEARCH BAR ────────────────────────── --}}
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col sm:flex-row gap-4 items-center justify-between">
        <form method="GET" action="{{ route('modules.billing.index') }}" class="flex-1 w-full sm:w-auto relative" id="search-form">
            <x-fas-magnifying-glass class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Search by patient name, ID, or invoice number…" 
                   class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
        </form>
        <div class="flex items-center gap-2 w-full sm:w-auto overflow-x-auto pb-1 sm:pb-0 hide-scrollbar">
            @foreach(['all'=>'All','pending'=>'Pending','paid'=>'Paid','overdue'=>'Overdue','cancelled'=>'Cancelled'] as $val => $label)
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
        @if($invoices->count())
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-500 font-semibold text-xs tracking-wide uppercase">
                            <th class="px-6 py-4">Invoice No.</th>
                            <th class="px-6 py-4">Patient</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4">Dates</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-slate-700">
                        @foreach($invoices as $inv)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 py-3.5">
                                    <p class="font-mono font-bold text-slate-900 group-hover:text-blue-600 transition-colors">{{ $inv->invoice_number }}</p>
                                </td>
                                <td class="px-6 py-3.5">
                                    <p class="font-bold text-slate-700">{{ $inv->patient->full_name }}</p>
                                    <p class="text-[11px] text-slate-500 mt-0.5 font-mono">{{ $inv->patient->patient_number }}</p>
                                </td>
                                <td class="px-6 py-3.5">
                                    <p class="font-black text-slate-900">{{ $currency_symbol }}{{ number_format($inv->total_amount, 2) }}</p>
                                </td>
                                <td class="px-6 py-3.5">
                                    <p class="text-xs text-slate-600"><span class="font-semibold">Issued:</span> {{ $inv->issue_date->format('M d, Y') }}</p>
                                    <p class="text-xs text-slate-600 mt-0.5"><span class="font-semibold">Due:</span> <span class="{{ \Carbon\Carbon::parse($inv->due_date)->isPast() && $inv->status !== 'paid' ? 'text-red-600 font-bold' : '' }}">{{ $inv->due_date->format('M d, Y') }}</span></p>
                                </td>
                                <td class="px-6 py-3.5">
                                    @if($inv->status === 'paid')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100/50 uppercase tracking-wider">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Paid
                                        </span>
                                    @elseif($inv->status === 'overdue')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-red-50 text-red-700 border border-red-100/50 uppercase tracking-wider">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Overdue
                                        </span>
                                    @elseif($inv->status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100/50 uppercase tracking-wider">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200/50 uppercase tracking-wider">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Cancelled
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-3.5 text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('modules.billing.show', $inv) }}" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors" title="View / Print">
                                            <x-fas-eye class="w-4 h-4" />
                                        </a>
                                        <a href="{{ route('modules.billing.edit', $inv) }}" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center hover:bg-slate-200 transition-colors" title="Edit Status">
                                            <x-fas-pen class="w-4 h-4" />
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- Pagination --}}
            @if($invoices->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $invoices->links() }}
                </div>
            @endif
        @else
            <div class="py-16 px-6 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-100">
                    <x-fas-folder-open class="w-8 h-8 text-slate-300" />
                </div>
                <h3 class="text-sm font-bold text-slate-900 mb-1">No Invoices Found</h3>
                <p class="text-xs text-slate-500 mb-4 max-w-sm mx-auto">There are no billing records matching your criteria. Create a new invoice to get started.</p>
                <a href="{{ route('modules.billing.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                    Create Invoice
                </a>
            </div>
        @endif
    </div>

</div>
</x-admin-layout>
