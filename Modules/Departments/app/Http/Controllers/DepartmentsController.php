<?php

namespace Modules\Departments\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Departments\Models\Department;

class DepartmentsController extends Controller
{
    /**
     * Display a list of all departments.
     */
    public function index(Request $request)
    {
        $query = Department::withCount('doctors');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('head_of_department', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $departments = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total'    => Department::count(),
            'active'   => Department::where('status', 'active')->count(),
            'inactive' => Department::where('status', 'inactive')->count(),
        ];

        return view('departments::index', compact('departments', 'stats'));
    }

    /**
     * Show the form to create a new department.
     */
    public function create()
    {
        return view('departments::create');
    }

    /**
     * Store a newly created department.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:255|unique:departments,name',
            'description'        => 'nullable|string',
            'head_of_department' => 'nullable|string|max:255',
            'phone'              => 'nullable|string|max:30',
            'location'           => 'nullable|string|max:255',
            'status'             => 'required|in:active,inactive',
        ]);

        Department::create($validated);

        return redirect()
            ->route('modules.departments.index')
            ->with('success', 'Department created successfully!');
    }

    /**
     * Show the form to edit a department.
     */
    public function edit(Department $dept)
    {
        return view('departments::edit', compact('dept'));
    }

    /**
     * Update a department.
     */
    public function update(Request $request, Department $dept)
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:255|unique:departments,name,' . $dept->id,
            'description'        => 'nullable|string',
            'head_of_department' => 'nullable|string|max:255',
            'phone'              => 'nullable|string|max:30',
            'location'           => 'nullable|string|max:255',
            'status'             => 'required|in:active,inactive',
        ]);

        $dept->update($validated);

        return redirect()
            ->route('modules.departments.index')
            ->with('success', 'Department updated successfully!');
    }

    /**
     * Delete a department.
     */
    public function destroy(Department $dept)
    {
        $dept->delete();

        return redirect()
            ->route('modules.departments.index')
            ->with('success', 'Department deleted successfully!');
    }
}
