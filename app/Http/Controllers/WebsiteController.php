<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Doctors\Models\Doctor;
use Modules\Departments\Models\Department;
use Modules\CMS\Models\Post;

class WebsiteController extends Controller
{
    /** Homepage */
    public function home()
    {
        return view('website.home');
    }

    /** About Us page */
    public function about()
    {
        return view('website.pages.about');
    }

    /** Departments / Services page */
    public function services()
    {
        $departments = Department::where('status', 'active')->get();
        return view('website.pages.services', compact('departments'));
    }

    /** Doctors listing page */
    public function doctors()
    {
        $doctors = Doctor::with('department')
            ->where('status', 'active')
            ->get();
        return view('website.pages.doctors', compact('doctors'));
    }

    /** Blog listing page */
    public function blog()
    {
        $posts = Post::where('status', 'published')
            ->latest('published_at')
            ->get();
        return view('website.pages.blog.index', compact('posts'));
    }

    /** Single blog post page */
    public function blogShow(string $slug)
    {
        $post    = Post::where('slug', $slug)->where('status', 'published')->firstOrFail();
        $related = Post::where('slug', '!=', $slug)
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('website.pages.blog.show', compact('post', 'related'));
    }

    /** Contact page */
    public function contact()
    {
        $doctors = Doctor::with('department')->where('status', 'active')->get();
        return view('website.pages.contact', compact('doctors'));
    }

    /** Book Appointment */
    public function bookAppointment(Request $request)
    {
        $request->validate([
            'patient_status'   => 'required|in:new,returning',
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|max:255',
            'phone'            => 'required|string|max:30',
            'doctor_id'        => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'subject'          => 'required|string|max:255',
            'message'          => 'required|string'
        ]);

        // Check for double booking
        $conflict = \Modules\Appointments\Models\Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($conflict) {
            return response()->json([
                'status'  => 'error',
                'message' => 'The selected time slot is already booked for this doctor. Please choose another time or doctor.'
            ], 422);
        }

        // Handle Patient
        if ($request->patient_status === 'returning') {
            $patient = \Modules\Patients\Models\Patient::where('email', $request->email)
                ->orWhere('phone', $request->phone)
                ->first();

            if (!$patient) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'We could not find a patient record matching this email or phone number. Please check your details or select "New Patient".'
                ], 404);
            }
        } else {
            // New Patient
            // Check if already exists to avoid duplicates
            $patient = \Modules\Patients\Models\Patient::where('email', $request->email)
                ->orWhere('phone', $request->phone)
                ->first();

            if (!$patient) {
                $names = explode(' ', $request->name, 2);
                $firstName = $names[0];
                $lastName = $names[1] ?? 'Unknown';

                $patient = \Modules\Patients\Models\Patient::create([
                    'first_name'     => $firstName,
                    'last_name'      => $lastName,
                    'email'          => $request->email,
                    'phone'          => $request->phone,
                    'uuid'           => \Illuminate\Support\Str::uuid(),
                    'patient_number' => 'PAT-' . time() . rand(10, 99),
                    'gender'         => 'Unknown',
                ]);
            }
        }

        // Create Appointment
        \Modules\Appointments\Models\Appointment::create([
            'patient_id'       => $patient->id,
            'doctor_id'        => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status'           => 'pending',
            'reason'           => $request->subject,
            'notes'            => $request->message
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Appointment booked successfully! We will contact you shortly to confirm.'
        ]);
    }
}
