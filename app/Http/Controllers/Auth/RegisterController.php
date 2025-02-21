<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {

        $validator = Validator::make($data, [          
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'school_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'phone_number' => ['required', 'string', 'max:15'],
            'profile_picture' => ['nullable', 'image'],
        ]);
    
        if ($validator->fails()) {
            // You can dump the errors here to see which field is failing
            dd($validator->errors());
        }
    
        return $validator;
    }

    protected function create(array $data)
    {
        $school = School::create([
            'school_name' => $data['school_name'],
            'address' => $data['address'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => Hash::make($data['password']),
            'profile_picture' => $data['profile_picture'] ?? null,
        ]);

        event(new Registered($school));

        return $school;
    }
}
