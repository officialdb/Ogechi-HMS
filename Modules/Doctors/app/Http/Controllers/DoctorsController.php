<?php

namespace Modules\Doctors\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Doctors\Models\Doctor;
use Modules\Doctors\Models\DoctorInvite;
use App\Notifications\DoctorInviteNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;

class DoctorsController extends Controller
{
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

    public function create()
    {
        return view('doctors::create');
    }

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
            'profile_photo'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Handle photo upload
        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo'] = $request->file('profile_photo')
                ->store('doctors/photos', 'public');
        } else {
            unset($validated['profile_photo']);
        }

        $doctor = Doctor::create($validated);

        if ($doctor->email) {
            $token = Str::random(60);
            DoctorInvite::create([
                'doctor_id'  => $doctor->id,
                'email'      => $doctor->email,
                'token'      => $token,
                'expires_at' => now()->addDays(7),
            ]);
            Notification::route('mail', $doctor->email)
                ->notify(new DoctorInviteNotification($token, $doctor->first_name));
        }

        return redirect()->route('modules.doctors.index')
                         ->with('success', 'Doctor registered and invite sent successfully.');
    }

    public function show(Doctor $doctor)
    {
        return view('doctors::show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        return view('doctors::edit', compact('doctor'));
    }

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
            'profile_photo'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'remove_photo'   => 'nullable|boolean',
        ]);

        // Handle photo removal
        if ($request->boolean('remove_photo') && $doctor->profile_photo) {
            Storage::disk('public')->delete($doctor->profile_photo);
            $validated['profile_photo'] = null;
        }
        // Handle new photo upload
        elseif ($request->hasFile('profile_photo')) {
            // Delete old photo
            if ($doctor->profile_photo) {
                Storage::disk('public')->delete($doctor->profile_photo);
            }
            $validated['profile_photo'] = $request->file('profile_photo')
                ->store('doctors/photos', 'public');
        } else {
            // No change to photo
            unset($validated['profile_photo']);
        }

        $previousStatus = $doctor->status;
        $doctor->update($validated);

        // Handle account access based on status change
        if ($doctor->user) {
            if ($validated['status'] === 'inactive') {
                $doctor->user->update(['is_active' => false]);
                $doctor->assignedPatients()->update(['assigned_doctor_id' => null]);
            } elseif ($previousStatus === 'inactive' && $validated['status'] !== 'inactive') {
                $doctor->user->update(['is_active' => true]);
            }
        }

        $message = match($validated['status']) {
            'inactive' => 'Doctor marked as inactive. Their account has been deactivated and patients unassigned.',
            'on_leave' => 'Doctor updated and set on leave.',
            default    => 'Doctor updated successfully.',
        };

        return redirect()->route('modules.doctors.show', $doctor)
                         ->with('success', $message);
    }

    public function destroy(Doctor $doctor)
    {
        // Clean up profile photo when deleting
        if ($doctor->profile_photo) {
            Storage::disk('public')->delete($doctor->profile_photo);
        }
        $doctor->delete();
        return redirect()->route('modules.doctors.index')
                         ->with('success', 'Doctor deleted successfully.');
    }
}
