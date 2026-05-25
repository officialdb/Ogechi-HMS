<?php

namespace Modules\Pharmacy\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Pharmacy\Models\Medication;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Medication::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('generic_name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $medications = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('pharmacy::index', compact('medications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pharmacy::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'category' => 'required|string|max:100',
            'manufacturer' => 'nullable|string|max:255',
            'quantity_in_stock' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = $this->determineStatus($validated['quantity_in_stock'], $validated['expiry_date'] ?? null);

        Medication::create($validated);

        return redirect()->route('modules.pharmacy.index')
                         ->with('success', 'Medication added to inventory successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medication $medication)
    {
        return view('pharmacy::edit', compact('medication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medication $medication)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'category' => 'required|string|max:100',
            'manufacturer' => 'nullable|string|max:255',
            'quantity_in_stock' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = $this->determineStatus($validated['quantity_in_stock'], $validated['expiry_date'] ?? null);

        $medication->update($validated);

        return redirect()->route('modules.pharmacy.index')
                         ->with('success', 'Medication inventory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medication $medication)
    {
        $medication->delete();
        return redirect()->route('modules.pharmacy.index')
                         ->with('success', 'Medication removed from inventory.');
    }

    /**
     * Helper to auto-calculate status based on stock and expiry
     */
    private function determineStatus($quantity, $expiryDate)
    {
        if ($quantity <= 0) return 'out_of_stock';
        if ($expiryDate && \Carbon\Carbon::parse($expiryDate)->isPast()) return 'expired';
        if ($quantity <= 20) return 'low_stock'; // arbitrary threshold for now
        return 'available';
    }
}
