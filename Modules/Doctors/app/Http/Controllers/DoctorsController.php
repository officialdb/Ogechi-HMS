<?php

namespace Modules\Doctors\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Doctors\Models\Doctor;

class DoctorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Doctor::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%")
                  ->orWhere('license_number', 'like', "%{$search}%");
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $doctors = $query->latest()->paginate(10)->withQueryString();

        return view('doctors::index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('doctors::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'email'          => 'nullable|email|max:255|unique:doctors,email',
            'phone'          => 'required|string|max:50',
            'license_number' => 'required|string|max:100|unique:doctors,license_number',
            'status'         => 'required|in:active,inactive,on_leave',
            'bio'            => 'nullable|string',
        ]);

        $doctor = Doctor::create($validated);

        return redirect()->route('modules.doctors.index')
                         ->with('success', 'Doctor registered successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show(Doctor $doctor)
    {
        return view('doctors::show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        return view('doctors::edit', compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'email'          => 'nullable|email|max:255|unique:doctors,email,' . $doctor->id,
            'phone'          => 'required|string|max:50',
            'license_number' => 'required|string|max:100|unique:doctors,license_number,' . $doctor->id,
            'status'         => 'required|in:active,inactive,on_leave',
            'bio'            => 'nullable|string',
        ]);

        $doctor->update($validated);

        return redirect()->route('modules.doctors.show', $doctor)
                         ->with('success', 'Doctor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('modules.doctors.index')
                         ->with('success', 'Doctor deleted successfully.');
    }
}
