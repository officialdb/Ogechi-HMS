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
        $user         = $request->user();
        $doctorRecord = $user->hasRole('Doctor') ? $user->doctor : null;

        $query = LabTest::with(['patient', 'doctor'])
            ->when($doctorRecord, fn($q) => $q->whereHas('patient', fn($p) =>
                $p->where('assigned_doctor_id', $doctorRecord->id)
            ));

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(fn($q) => $q
                ->where('test_name', 'like', "%{$search}%")
                ->orWhere('test_type', 'like', "%{$search}%")
                ->orWhereHas('patient', fn($p) => $p
                    ->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name',  'like', "%{$search}%")
                )
            );
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('test_type', $request->type);
        }

        $tests = $query->latest()->paginate(15)->withQueryString();

        // Stats also scoped to the doctor's patients
        $baseStats = LabTest::when($doctorRecord, fn($q) => $q->whereHas('patient', fn($p) =>
            $p->where('assigned_doctor_id', $doctorRecord->id)
        ));

        $stats = [
            'total'      => (clone $baseStats)->count(),
            'pending'    => (clone $baseStats)->where('status', 'pending')->count(),
            'processing' => (clone $baseStats)->where('status', 'processing')->count(),
            'completed'  => (clone $baseStats)->where('status', 'completed')->count(),
        ];

        return view('laboratory::index', compact('tests', 'stats'));
    }

    public function create()
    {
        $user         = auth()->user();
        $doctorRecord = $user->hasRole('Doctor') ? $user->doctor : null;

        // Doctors can only request tests for their own patients
        $patients = Patient::select('id', 'first_name', 'last_name', 'patient_number')
            ->when($doctorRecord, fn($q) => $q->where('assigned_doctor_id', $doctorRecord->id))
            ->orderBy('first_name')
            ->get();

        $doctors = Doctor::where('status', '!=', 'inactive')
            ->select('id', 'first_name', 'last_name', 'specialization')
            ->orderBy('first_name')
            ->get();

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
