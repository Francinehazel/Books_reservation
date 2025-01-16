<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Show the student registration form.
     */
    public function showRegisterForm()
    {
        return view('auth.student-register');
    }

    /**
     * Handle student registration form submission.
     */
    public function register(Request $request)
    {
        // Validate form inputs
        $validatedData = $request->validate([
            'email' => 'required|email|unique:students,email',
            'student_id' => 'required|regex:/^\d{4}-\d{5}-[A-Z]{2}-\d$/|unique:students,student_id',
            'year_section' => 'required|regex:/^\d{1}-\d{1}$/',
            'program' => 'required|string|max:100',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other,Prefer not to say',
            'birthday' => 'required|date',
            'password' => 'required|min:8|confirmed',
            'contact' => 'required|digits:11', // Ensure it's a valid 11-digit contact number
        ]);

        try {
            // Create the student record
            Student::create([
                'email' => $validatedData['email'],
                'student_id' => $validatedData['student_id'],
                'year_section' => $validatedData['year_section'],
                'program' => $validatedData['program'],
                'name' => $validatedData['name'],
                'gender' => $validatedData['gender'],
                'birthday' => $validatedData['birthday'],
                'password' => Hash::make($validatedData['password']),
                'contact' => $validatedData['contact'],
            ]);

            // Redirect the user to the login page with a success message
            return redirect()->route('student.login')->with('success', 'Account created successfully! Please log in.');

        } catch (\Exception $e) {
            // Log the error for debugging (optional)
            \Log::error('Student Registration Error: ' . $e->getMessage());

            // Redirect back with error message
            return back()->with('error', 'An error occurred during registration. Please try again.');
        }
    }
}
