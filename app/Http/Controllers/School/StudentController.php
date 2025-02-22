<?php

namespace App\Http\Controllers\School;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        $query = Student::where('school_id', Auth::id());

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
    public function createImportStudents()
    {
        return view('school.students.import');
    }


    public function importStudents(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048'
        ]);

        $file = $request->file('file');
        $fileData = file($file->getPathname());

        $schoolId = Auth::user()->id;
        $headerSkipped = false;
        $students = [];

        foreach ($fileData as $line) {
            if (!$headerSkipped) {
                $headerSkipped = true;
                continue;
            }

            $data = str_getcsv($line);

            // Ensure there are at least 10 columns
            if (count($data) >= 10) {
                $profilePicturePath = null;

                // Validate name, email, class, age, gender, and other fields
                if (
                    empty($data[0]) || empty($data[1]) || empty($data[2]) || empty($data[3]) ||
                    empty($data[4]) || empty($data[5]) || empty($data[6]) || empty($data[7]) ||
                    empty($data[8]) || empty($data[9])
                ) {
                    continue; // Skip invalid rows
                }

                // Validate email format
                if (!filter_var($data[1], FILTER_VALIDATE_EMAIL)) {
                    continue;
                }

                // Validate age is numeric
                if (!is_numeric($data[3]) || $data[3] < 1 || $data[3] > 100) {
                    continue;
                }

                // Handle profile picture (check if it's a valid file path)
                if (!empty($data[5]) && file_exists($data[5])) {
                    $filename = uniqid() . '_' . basename($data[5]); // Generate unique filename
                    $destinationPath = storage_path('app/public/student_profiles/');

                    // Ensure directory exists
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }

                    // Move the file to storage
                    copy($data[5], $destinationPath . $filename);

                    // Save relative path in DB
                    $profilePicturePath = 'student_profiles/' . $filename;
                }

                $students[] = [
                    'name' => $data[0],
                    'email' => $data[1],
                    'class' => $data[2],
                    'age' => $data[3],
                    'gender' => $data[4],
                    'profile_picture' => $profilePicturePath,
                    'country' => $data[6],
                    'state' => $data[7],
                    'city' => $data[8],
                    'zip_code' => $data[9],
                    'school_id' => $schoolId,
                    'imported' => 'true',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert students into the database
        if (!empty($students)) {
            Student::insert($students);
            return redirect()->route('School.importStudents')->with('success', 'Students imported successfully.');
        }

        return redirect()->route('School.importStudents')->with('error', 'Invalid CSV format or empty file.');
    }
}
