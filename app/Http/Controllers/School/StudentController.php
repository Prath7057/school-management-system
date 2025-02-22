<?php

namespace App\Http\Controllers\School;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class StudentController extends Controller
{
    // Show the add student form
    public function create()
    {
        return view('school.students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'class' => 'required|string',
            'age' => 'required|numeric',
            'gender' => 'required|in:Male,Female,Other',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'zip_code' => 'required|string',
        ]);

        $profile_picture = null;
        if ($request->hasFile('profile_picture')) {
            $profile_picture = $request->file('profile_picture')->store('student_profiles', 'public');
        }

        Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'class' => $request->class,
            'age' => $request->age,
            'gender' => $request->gender,
            'profile_picture' => $profile_picture,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'zip_code' => $request->zip_code,
            'school_id' => Auth::user()->id, // Assign logged-in school
        ]);

        return redirect()->route('School.listStudents')->with('success', 'Student added successfully.');
    }

    public function index(Request $request)
    {
        $query = Student::query();
    
        if ($request->has('class') && $request->class !== null) {
            $query->where('class', $request->class);
        }
        if ($request->has('age') && $request->age !== null) {
            $query->where('age', $request->age);
        }
        if ($request->has('city') && $request->city !== null) {
            $query->where('city', $request->city);
        }
    
        $students = $query->get();
    
        return view('school.students.index', compact('students'));
    }

    // Show edit form
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('school.students.edit', compact('student'));
    }

    // Update student
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'class' => 'required|string',
            'age' => 'required|numeric',
            'gender' => 'required|in:Male,Female,Other',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'zip_code' => 'required|string',
        ]);

        if ($request->hasFile('profile_picture')) {
            if ($student->profile_picture) {
                Storage::disk('public')->delete($student->profile_picture);
            }

            $profile_picture = $request->file('profile_picture')->store('student_profiles', 'public');
            $student->profile_picture = $profile_picture;
        }

        $student->update($request->except('profile_picture'));

        return redirect()->route('School.listStudents')->with('success', 'Student updated successfully.');
    }

    // Delete student
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        if ($student->profile_picture) {
            Storage::delete('public/' . $student->profile_picture);
        }
        $student->delete();

        return redirect()->route('School.listStudents')->with('success', 'Student deleted successfully.');
    }
    //

    
}
