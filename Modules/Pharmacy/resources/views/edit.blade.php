<x-admin-layout title="Edit Medication">
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Breadcrumb & Header --}}
    <div>
        <div class="flex items-center gap-2 text-xs text-slate-400 mb-3">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
            <x-fas-chevron-right class="w-3 h-3" />
            <a href="{{ route('modules.pharmacy.index') }}" class="hover:text-blue-600 transition-colors">Pharmacy</a>
            <x-fas-chevron-right class="w-3 h-3" />
            <span class="text-slate-600 font-semibold">{{ $medication->name }}</span>
        </div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Edit / Restock Medication</h1>
        <p class="text-sm text-slate-500 mt-1">Update inventory levels, pricing, or details.</p>
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
    <form method="POST" action="{{ route('modules.pharmacy.update', $medication) }}" class="bg-white border border-slate-100 shadow-sm rounded-2xl overflow-hidden">
        @csrf
        @method('PUT')
        
        <div class="p-6 sm:p-8 space-y-8">
            {{-- Drug Details --}}
            <div>
                <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2 border-b border-slate-100 pb-2">
                    <div class="w-6 h-6 bg-blue-50 text-blue-600 rounded flex items-center justify-center"><x-fas-file-alt class="w-3.5 h-3.5" /></div>
                    Drug Information
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Brand Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $medication->name) }}" required 
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Generic Name</label>
                        <input type="text" name="generic_name" value="{{ old('generic_name', $medication->generic_name) }}" 
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Category <span class="text-red-500">*</span></label>
                        <select name="category" required class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700">
                            @php $currCat = old('category', $medication->category); @endphp
                            @foreach(['Tablet', 'Syrup', 'Capsule', 'Injection', 'Ointment', 'Drops', 'Inhaler', 'Suppository'] as $cat)
                                <option value="{{ $cat }}" {{ $currCat === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Manufacturer</label>
                        <input type="text" name="manufacturer" value="{{ old('manufacturer', $medication->manufacturer) }}" 
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                    </div>
                </div>
            </div>

            {{-- Inventory Info --}}
            <div>
                <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2 border-b border-slate-100 pb-2">
                    <div class="w-6 h-6 bg-violet-50 text-violet-600 rounded flex items-center justify-center"><x-fas-wallet class="w-3.5 h-3.5" /></div>
                    Inventory Details
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Quantity (Units) <span class="text-red-500">*</span></label>
                        <input type="number" name="quantity_in_stock" value="{{ old('quantity_in_stock', $medication->quantity_in_stock) }}" min="0" required 
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700 font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Minimum Stock Level <span class="text-red-500">*</span></label>
                        <input type="number" name="min_stock" value="{{ old('min_stock', $medication->min_stock) }}" min="0" required 
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Unit Price ({{ $currency_symbol ?? '$' }}) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="unit_price" value="{{ old('unit_price', number_format($medication->unit_price, 2, '.', '')) }}" min="0" required 
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Expiry Date</label>
                        @php $exp = $medication->expiry_date ? $medication->expiry_date->format('Y-m-d') : ''; @endphp
                        <input type="date" name="expiry_date" value="{{ old('expiry_date', $exp) }}" 
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Storage Notes / Instructions</label>
                        <textarea name="notes" rows="3" 
                                  class="w-full px-4 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400 resize-none">{{ old('notes', $medication->notes) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="px-6 sm:px-8 py-5 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-3">
            <button type="button" x-data @click="if(confirm('Are you sure you want to completely remove this medication from the inventory? This cannot be undone.')) { document.getElementById('delete-med-form').submit(); }" class="px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-50 rounded-xl transition-colors">
                Delete Record
            </button>
            <div class="flex items-center gap-3">
                <a href="{{ route('modules.pharmacy.index') }}" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200 hover:bg-slate-100 rounded-xl transition-colors">Cancel</a>
                <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                    Save Changes
                </button>
            </div>
        </div>
    </form>

    <form id="delete-med-form" method="POST" action="{{ route('modules.pharmacy.destroy', $medication) }}" class="hidden">
        @csrf
        @method('DELETE')
    </form>

</div>
</x-admin-layout>
