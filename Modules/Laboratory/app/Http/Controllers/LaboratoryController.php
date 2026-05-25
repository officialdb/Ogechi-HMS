<?php

namespace Modules\Laboratory\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Laboratory\Models\LabTest;
use Modules\Patients\Models\Patient;
use Modules\Doctors\Models\Doctor;

class LaboratoryController extends Controller
{
    public function index(Request $request)
    {
        $query = LabTest::with(['patient', 'doctor']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('test_name', 'like', "%{$search}%")
                  ->orWhere('test_type', 'like', "%{$search}%")
                  ->orWhereHas('patient', fn($q) => $q
                      ->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name',  'like', "%{$search}%")
                  );
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('test_type', $request->type);
        }

        $tests = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total'      => LabTest::count(),
            'pending'    => LabTest::where('status', 'pending')->count(),
            'processing' => LabTest::where('status', 'processing')->count(),
            'completed'  => LabTest::where('status', 'completed')->count(),
        ];

        return view('laboratory::index', compact('tests', 'stats'));
    }

    public function create()
    {
        $patients = Patient::select('id', 'first_name', 'last_name', 'patient_number')->orderBy('first_name')->get();
        $doctors  = Doctor::where('status', '!=', 'inactive')->select('id', 'first_name', 'last_name', 'specialization')->orderBy('first_name')->get();
        return view('laboratory::create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id'  => 'nullable|exists:doctors,id',
            'test_name'  => 'required|string|max:255',
            'test_type'  => 'required|string|max:100',
            'notes'      => 'nullable|string',
            'cost'       => 'required|numeric|min:0',
        ]);

        $validated['status'] = 'pending';
        LabTest::create($validated);

        return redirect()->route('modules.laboratory.index')
                         ->with('success', 'Lab test requested successfully.');
    }

    public function edit(LabTest $laboratory)
    {
        $laboratory->load(['patient', 'doctor']);
        $patients = Patient::select('id', 'first_name', 'last_name', 'patient_number')->orderBy('first_name')->get();
        $doctors  = Doctor::where('status', '!=', 'inactive')->select('id', 'first_name', 'last_name', 'specialization')->orderBy('first_name')->get();
        return view('laboratory::edit', compact('laboratory', 'patients', 'doctors'));
    }

    public function update(Request $request, LabTest $laboratory)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id'  => 'nullable|exists:doctors,id',
            'test_name'  => 'required|string|max:255',
            'test_type'  => 'required|string|max:100',
            'status'     => 'required|in:pending,processing,completed,cancelled',
            'result'     => 'nullable|string',
            'notes'      => 'nullable|string',
            'cost'       => 'required|numeric|min:0',
            'tested_at'  => 'nullable|date',
        ]);

        $laboratory->update($validated);

        return redirect()->route('modules.laboratory.index')
                         ->with('success', 'Lab test updated successfully.');
    }

    public function destroy(LabTest $laboratory)
    {
        $laboratory->delete();
        return redirect()->route('modules.laboratory.index')
                         ->with('success', 'Lab test deleted.');
    }
}
