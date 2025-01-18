<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
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
            'contact' => 'required|digits:11',
        ]);

        // Check for soft-deleted accounts
        $existingStudent = Student::onlyTrashed()->where('email', $validatedData['email'])->first();
        if ($existingStudent) {
            return back()->with('error', 'This email belongs to an account that has been deactivated. Please contact support for recovery.');
        }

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

        // Redirect to login page with a success message
        return redirect()->route('student.login')->with('success', 'Account created successfully! Please log in.');
    }

    public function userManagement()
    {
        // Retrieve the currently authenticated student
        $student = Auth::guard('student')->user();

        // Pass the student's data to the view
        return view('student.user-management', compact('student'));
    }

    public function updateProfile(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . auth()->id(),
            'contact' => 'required|digits:11',
        ]);

        // Retrieve the currently authenticated student
        $student = auth()->guard('student')->user();

        // Update the student's profile
        $student->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'contact' => $validatedData['contact'],
        ]);

        // Redirect back with a success message
        return redirect()->route('student.user-management')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        // Retrieve the authenticated student
        $student = auth()->guard('student')->user();

        // Check if the current password is correct
        if (!Hash::check($validatedData['current_password'], $student->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update the password
        $student->password = Hash::make($validatedData['new_password']);
        $student->save();

        return back()->with('success', 'Password updated successfully!');
    }

    public function deleteAccount(Request $request)
    {
        // Retrieve the authenticated student
        $student = auth()->guard('student')->user();

        // Perform a soft delete on the student's account
        $student->delete();

        // Log out the student
        auth()->guard('student')->logout();

        // Redirect to the login page with a success message
        return redirect()->route('student.login')->with('success', 'Your account has been deleted successfully. Contact support if you wish to recover it.');
    }
}