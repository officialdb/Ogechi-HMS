<x-admin-layout title="Create Invoice">
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Breadcrumb & Header --}}
    <div>
        <div class="flex items-center gap-2 text-xs text-slate-400 mb-3">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
            <x-fas-tachometer-alt class="w-3 h-3" />
            <a href="{{ route('modules.billing.index') }}" class="hover:text-blue-600 transition-colors">Billing</a>
            <x-fas-tachometer-alt class="w-3 h-3" />
            <span class="text-slate-600 font-semibold">New Invoice</span>
        </div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Create Invoice</h1>
        <p class="text-sm text-slate-500 mt-1">Generate a new medical bill and add line items.</p>
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

    {{-- Form --}}
    <form method="POST" action="{{ route('modules.billing.store') }}" class="bg-white border border-slate-100 shadow-sm rounded-2xl overflow-hidden" x-data="invoiceForm()">
        @csrf
        
        <div class="p-6 sm:p-8 space-y-8">
            {{-- Invoice Meta --}}
            <div>
                <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2 border-b border-slate-100 pb-2">
                    <div class="w-6 h-6 bg-blue-50 text-blue-600 rounded flex items-center justify-center"><x-fas-tachometer-alt class="w-3.5 h-3.5" /></div>
                    Invoice Details
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Select Patient <span class="text-red-500">*</span></label>
                        <select name="patient_id" required class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700">
                            <option value="">Choose Patient...</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->full_name }} ({{ $patient->patient_number }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Invoice Number <span class="text-red-500">*</span></label>
                        <input type="text" name="invoice_number" value="{{ old('invoice_number', $nextInvoiceNumber) }}" required readonly
                               class="w-full px-4 py-2.5 text-sm bg-slate-100 border border-slate-200 rounded-xl font-mono text-slate-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                        <select name="status" required class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700">
                            <option value="pending" {{ old('status')==='pending' ? 'selected':'' }}>Pending</option>
                            <option value="paid" {{ old('status')==='paid' ? 'selected':'' }}>Paid</option>
                            <option value="overdue" {{ old('status')==='overdue' ? 'selected':'' }}>Overdue</option>
                        </select>
                    </div>
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Issue Date <span class="text-red-500">*</span></label>
                        <input type="date" name="issue_date" value="{{ old('issue_date', date('Y-m-d')) }}" required 
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700">
                    </div>
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Due Date <span class="text-red-500">*</span></label>
                        <input type="date" name="due_date" value="{{ old('due_date', date('Y-m-d', strtotime('+7 days'))) }}" required 
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700">
                    </div>
                </div>
            </div>

            {{-- Line Items --}}
            <div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-2 mb-4">
                    <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-6 h-6 bg-violet-50 text-violet-600 rounded flex items-center justify-center"><x-fas-tachometer-alt class="w-3.5 h-3.5" /></div>
                        Line Items
                    </h3>
                    <button type="button" @click="addItem()" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg transition-colors flex items-center gap-1">
                        <x-fas-calendar-alt class="w-3 h-3" /> Add Row
                    </button>
                </div>
                
                <div class="space-y-3">
                    <div class="hidden sm:grid grid-cols-12 gap-3 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        <div class="col-span-6">Description</div>
                        <div class="col-span-2 text-center">Qty</div>
                        <div class="col-span-2 text-right">Unit Price ($)</div>
                        <div class="col-span-2 text-right pr-8">Total</div>
                    </div>
                    
                    <template x-for="(item, index) in items" :key="index">
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center bg-slate-50 p-4 sm:p-2 sm:bg-transparent rounded-xl sm:rounded-none border sm:border-0 border-slate-100 relative">
                            <div class="col-span-6">
                                <label class="sm:hidden block text-xs font-bold text-slate-500 mb-1">Description</label>
                                <input type="text" x-model="item.description" :name="`items[${index}][description]`" required placeholder="e.g. Consultation Fee" 
                                       class="w-full px-3 py-2 text-sm bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors">
                            </div>
                            <div class="col-span-2">
                                <label class="sm:hidden block text-xs font-bold text-slate-500 mb-1 mt-2">Quantity</label>
                                <input type="number" x-model="item.quantity" :name="`items[${index}][quantity]`" required min="1" @input="calculateTotals()"
                                       class="w-full px-3 py-2 text-sm bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors sm:text-center">
                            </div>
                            <div class="col-span-2">
                                <label class="sm:hidden block text-xs font-bold text-slate-500 mb-1 mt-2">Unit Price</label>
                                <input type="number" step="0.01" x-model="item.unit_price" :name="`items[${index}][unit_price]`" required min="0" @input="calculateTotals()"
                                       class="w-full px-3 py-2 text-sm bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors sm:text-right">
                            </div>
                            <div class="col-span-2 flex items-center justify-between sm:justify-end gap-3 sm:pr-2">
                                <label class="sm:hidden block text-xs font-bold text-slate-500 mt-2">Line Total</label>
                                <div class="font-bold text-slate-700 tabular-nums">$<span x-text="formatMoney(item.quantity * item.unit_price)"></span></div>
                                <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="w-7 h-7 bg-red-50 text-red-500 rounded flex items-center justify-center hover:bg-red-500 hover:text-white transition-colors absolute top-3 right-3 sm:relative sm:top-0 sm:right-0">
                                    <x-fas-tachometer-alt class="w-4 h-4" />
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Totals --}}
                <div class="mt-6 pt-5 border-t border-slate-100 flex justify-end">
                    <div class="w-full sm:w-64 space-y-3">
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-bold text-slate-500">Subtotal</span>
                            <span class="font-black text-slate-800">$<span x-text="formatMoney(subtotal)"></span></span>
                        </div>
                        <div class="flex justify-between items-center text-sm border-t border-slate-100 pt-3">
                            <span class="font-black text-slate-900 text-lg">Total Due</span>
                            <span class="font-black text-blue-600 text-2xl">$<span x-text="formatMoney(subtotal)"></span></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Notes --}}
            <div class="pt-6 border-t border-slate-100">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Additional Notes (Optional)</label>
                <textarea name="notes" rows="2" 
                          class="w-full px-4 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400 resize-none" 
                          placeholder="Payment instructions or message to patient...">{{ old('notes') }}</textarea>
            </div>
        </div>
        
        <div class="px-6 sm:px-8 py-5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('modules.billing.index') }}" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200 hover:bg-slate-100 rounded-xl transition-colors">Cancel</a>
            <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                Save Invoice
            </button>
        </div>
    </form>

</div>

{{-- Alpine JS logic for dynamic form --}}
<script src="//unpkg.com/alpinejs" defer></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('invoiceForm', () => ({
            items: [
                { description: '', quantity: 1, unit_price: 0 }
            ],
            subtotal: 0,
            
            init() {
                this.calculateTotals();
            },
            
            addItem() {
                this.items.push({ description: '', quantity: 1, unit_price: 0 });
            },
            
            removeItem(index) {
                this.items.splice(index, 1);
                this.calculateTotals();
            },
            
            calculateTotals() {
                this.subtotal = this.items.reduce((sum, item) => {
                    return sum + (item.quantity * item.unit_price);
                }, 0);
            },
            
            formatMoney(value) {
                return Number(value).toFixed(2);
            }
        }))
    });
</script>
</x-admin-layout>
