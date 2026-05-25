<?php

namespace Modules\Billing\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Billing\Models\Invoice;
use Modules\Billing\Models\InvoiceItem;
use Modules\Patients\Models\Patient;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Invoice::with('patient');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('patient', function($q) use ($search) {
                      $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('patient_number', 'like', "%{$search}%");
                  });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $invoices = $query->latest('issue_date')->paginate(10)->withQueryString();

        return view('billing::index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::select('id', 'first_name', 'last_name', 'patient_number')->orderBy('first_name')->get();
        // Generate a random invoice number for display
        $nextInvoiceNumber = 'INV-' . strtoupper(Str::random(6));
        
        return view('billing::create', compact('patients', 'nextInvoiceNumber'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'invoice_number' => 'required|string|unique:invoices,invoice_number',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'status' => 'required|in:pending,paid,overdue,cancelled',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $subtotal = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $total = $item['quantity'] * $item['unit_price'];
                $subtotal += $total;
                $itemsData[] = [
                    'description' => $item['description'],
                    'quantity'    => $item['quantity'],
                    'unit_price'  => $item['unit_price'],
                    'total'       => $total,
                ];
            }

            // Simple tax/discount logic could be added here later, keeping it 0 for now based on items total
            $tax_amount = 0;
            $discount_amount = 0;
            $total_amount = $subtotal + $tax_amount - $discount_amount;

            $invoice = Invoice::create([
                'invoice_number'  => $request->invoice_number,
                'patient_id'      => $request->patient_id,
                'issue_date'      => $request->issue_date,
                'due_date'        => $request->due_date,
                'status'          => $request->status,
                'notes'           => $request->notes,
                'subtotal'        => $subtotal,
                'tax_amount'      => $tax_amount,
                'discount_amount' => $discount_amount,
                'total_amount'    => $total_amount,
            ]);

            foreach ($itemsData as $data) {
                $invoice->items()->create($data);
            }
        });

        return redirect()->route('modules.billing.index')
                         ->with('success', 'Invoice generated successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['patient', 'items']);
        return view('billing::show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     * For simplicity, edit just allows status and dates updates, not full line item rebuilds yet.
     */
    public function edit(Invoice $invoice)
    {
        $invoice->load('items');
        return view('billing::edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'status' => 'required|in:pending,paid,overdue,cancelled',
            'notes' => 'nullable|string',
        ]);

        $invoice->update($validated);

        return redirect()->route('modules.billing.show', $invoice)
                         ->with('success', 'Invoice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('modules.billing.index')
                         ->with('success', 'Invoice deleted.');
    }
}
