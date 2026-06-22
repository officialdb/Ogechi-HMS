<x-admin-layout title="Invoice {{ $invoice->invoice_number }}">
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Breadcrumb & Header --}}
    <div class="print:hidden flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-400 mb-3">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('modules.billing.index') }}" class="hover:text-blue-600 transition-colors">Billing</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-600 font-semibold">{{ $invoice->invoice_number }}</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Invoice Details</h1>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-5 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 rounded-xl transition-colors shadow-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print Invoice
            </button>
            <form action="{{ route('modules.billing.destroy', $invoice) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this invoice?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-red-600 bg-white border border-red-200 hover:bg-red-50 rounded-xl transition-colors shadow-sm">
                    Delete
                </button>
            </form>
        </div>
    </div>

    {{-- Printable Invoice Card --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8 sm:p-12 print:border-0 print:shadow-none print:p-0 print:text-black">
        
        {{-- Invoice Header --}}
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-8 border-b border-slate-100 pb-8 mb-8 print:border-slate-300">
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center text-white font-black text-xl shadow-lg shadow-blue-600/20 print:shadow-none print:bg-black">
                        O
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-900 print:text-black tracking-tight">Ogechi Hospital</h2>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest print:text-slate-600">Medical Center</p>
                    </div>
                </div>
                <div class="text-sm text-slate-500 space-y-1 print:text-slate-700">
                    <p>123 Medical Avenue</p>
                    <p>Health City, HC 12345</p>
                    <p>Phone: +1 234 567 8900</p>
                    <p>Email: billing@ogechihospital.com</p>
                </div>
            </div>
            <div class="text-left sm:text-right">
                <h1 class="text-4xl font-black text-slate-200 uppercase tracking-tight mb-4 print:text-slate-400">Invoice</h1>
                <p class="text-lg font-bold text-slate-900 print:text-black mb-1">{{ $invoice->invoice_number }}</p>
                @if($invoice->status === 'paid')
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase tracking-widest print:border-2">
                        PAID IN FULL
                    </span>
                @elseif($invoice->status === 'overdue')
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold bg-red-50 text-red-700 border border-red-200 uppercase tracking-widest print:border-2">
                        OVERDUE
                    </span>
                @elseif($invoice->status === 'cancelled')
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold bg-slate-100 text-slate-600 border border-slate-200 uppercase tracking-widest print:border-2">
                        CANCELLED
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold bg-amber-50 text-amber-700 border border-amber-200 uppercase tracking-widest print:border-2">
                        PENDING PAYMENT
                    </span>
                @endif
            </div>
        </div>

        {{-- Patient & Dates --}}
        <div class="flex flex-col sm:flex-row justify-between gap-8 mb-10">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Billed To</p>
                <p class="text-lg font-black text-slate-900 print:text-black">{{ $invoice->patient->full_name }}</p>
                <div class="text-sm text-slate-600 mt-1 space-y-1 print:text-slate-700">
                    <p><span class="font-semibold text-slate-400">ID:</span> {{ $invoice->patient->patient_number }}</p>
                    @if($invoice->patient->phone) <p><span class="font-semibold text-slate-400">Phone:</span> {{ $invoice->patient->phone }}</p> @endif
                    @if($invoice->patient->address) <p><span class="font-semibold text-slate-400">Address:</span> {{ $invoice->patient->address }}, {{ $invoice->patient->city }}</p> @endif
                </div>
            </div>
            <div class="text-left sm:text-right">
                <div class="grid grid-cols-2 sm:flex sm:flex-col gap-4 sm:gap-2 text-sm">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Date Issued</p>
                        <p class="font-bold text-slate-900 print:text-black">{{ $invoice->issue_date->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Payment Due</p>
                        <p class="font-bold text-slate-900 print:text-black">{{ $invoice->due_date->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Line Items Table --}}
        <div class="mb-10 border border-slate-200 rounded-2xl overflow-hidden print:border-slate-400">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 print:bg-slate-100 print:border-slate-400">
                        <th class="px-6 py-4 font-bold text-slate-700 uppercase tracking-wider text-xs print:text-black">Description</th>
                        <th class="px-6 py-4 font-bold text-slate-700 uppercase tracking-wider text-xs text-center print:text-black">Qty</th>
                        <th class="px-6 py-4 font-bold text-slate-700 uppercase tracking-wider text-xs text-right print:text-black">Unit Price</th>
                        <th class="px-6 py-4 font-bold text-slate-700 uppercase tracking-wider text-xs text-right print:text-black">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 print:divide-slate-300">
                    @foreach($invoice->items as $item)
                        <tr class="bg-white print:text-black text-slate-700">
                            <td class="px-6 py-4 font-medium">{{ $item->description }}</td>
                            <td class="px-6 py-4 text-center tabular-nums">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 text-right tabular-nums">{{ $currency_symbol }}{{ number_format($item->unit_price, 2) }}</td>
                            <td class="px-6 py-4 text-right font-bold text-slate-900 tabular-nums print:text-black">{{ $currency_symbol }}{{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Totals --}}
        <div class="flex flex-col sm:flex-row justify-between items-end gap-8 border-t border-slate-100 pt-8 print:border-slate-300">
            <div class="w-full sm:w-1/2">
                @if($invoice->notes)
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Notes</p>
                    <p class="text-sm text-slate-600 print:text-slate-800">{{ $invoice->notes }}</p>
                @endif
            </div>
            <div class="w-full sm:w-72 space-y-3 text-sm">
                <div class="flex justify-between items-center text-slate-600 print:text-slate-800">
                    <span class="font-semibold">Subtotal</span>
                    <span class="tabular-nums">{{ $currency_symbol }}{{ number_format($invoice->subtotal, 2) }}</span>
                </div>
                @if($invoice->tax_amount > 0)
                <div class="flex justify-between items-center text-slate-600 print:text-slate-800">
                    <span class="font-semibold">Tax</span>
                    <span class="tabular-nums">{{ $currency_symbol }}{{ number_format($invoice->tax_amount, 2) }}</span>
                </div>
                @endif
                @if($invoice->discount_amount > 0)
                <div class="flex justify-between items-center text-emerald-600">
                    <span class="font-semibold">Discount</span>
                    <span class="tabular-nums">-{{ $currency_symbol }}{{ number_format($invoice->discount_amount, 2) }}</span>
                </div>
                @endif
                <div class="flex justify-between items-center border-t border-slate-200 pt-4 mt-2 print:border-slate-400">
                    <span class="font-black text-slate-900 text-lg uppercase tracking-wider print:text-black">Total Due</span>
                    <span class="font-black text-blue-600 text-2xl tabular-nums print:text-black">{{ $currency_symbol }}{{ number_format($invoice->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="mt-16 text-center text-xs text-slate-400 font-medium print:text-slate-500">
            <p>Thank you for choosing Ogechi Hospital.</p>
            <p class="mt-1">Please make checks payable to "Ogechi Medical Center".</p>
        </div>

    </div>
</div>
</x-admin-layout>
