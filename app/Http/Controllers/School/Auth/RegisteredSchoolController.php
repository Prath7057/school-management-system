<?php

namespace App\Http\Controllers\School\Auth;

use App\Models\School;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;

class RegisteredSchoolController extends Controller
{
    public function create()
    {
        return view('School.auth.register');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:schools,email',
            'phone' => 'required|numeric',
            'password' => 'required|min:6|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);
        
        $school = School::create([
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('school_profiles', $filename, 'public');
    
            $school->profile_picture = $path;
            $school->save();
        }

         event(new Registered($school));
 
         return redirect()->route('School.login')->with('message', 'Registration successful! Please verify your email.');
    }
}
