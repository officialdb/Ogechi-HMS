<?php

namespace Modules\Doctors\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Doctors\Models\DoctorInvite;
use Modules\Doctors\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class DoctorInviteController extends Controller
{
    public function show($token)
    {
        $invite = DoctorInvite::where('token', $token)
                    ->whereNull('used_at')
                    ->where('expires_at', '>', now())
                    ->firstOrFail();

        $doctor = $invite->doctor;

        if ($doctor->user_id) {
            abort(403, 'This doctor account is already registered.');
        }

        return view('doctors::invite', compact('invite', 'doctor'));
    }

    public function store(Request $request, $token)
    {
        $invite = DoctorInvite::where('token', $token)
                    ->whereNull('used_at')
                    ->where('expires_at', '>', now())
                    ->firstOrFail();

        $doctor = $invite->doctor;

        if ($doctor->user_id) {
            abort(403, 'This doctor account is already registered.');
        }

        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        // Create User
        $user = User::create([
            'name' => "Dr. {$doctor->first_name} {$doctor->last_name}",
            'email' => $invite->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(), // Assume verified since they clicked email link
        ]);

        // Assign Role
        $user->assignRole('Doctor');

        // Link Doctor to User
        $doctor->update(['user_id' => $user->id]);

        // Mark invite as used
        $invite->update(['used_at' => now()]);

        // Log the user in
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Welcome to your Doctor Dashboard!');
    }
}
