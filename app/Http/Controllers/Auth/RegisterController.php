<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'matric_no' => ['required', 'string', 'max:255', 'regex:/^U\d{2}\/[A-Z]{3}\/[A-Z]{3}\/\d{4}$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        // Extract faculty and department codes from matric number
        $matricNumber = $data['matric_no']; // Adjust field name if needed

        // Assuming the format U19/FNS/CSC/1065
        $facultyCode = substr($matricNumber, 4, 3); // Extract 'FNS'
        $deptCode = substr($matricNumber, 8, 3);    // Extract 'CSC'

        // Find faculty and department IDs
        $faculty = DB::table('faculty')
            ->where('faculty_code', $facultyCode)
            ->first();

        $department = DB::table('departments')
            ->where('dept_code', $deptCode)
            ->first();

        if (!$faculty || !$department) {
            // Handle faculty or department not found
            return redirect()->back()->withErrors(['matric_no' => 'Invalid faculty or department code']);
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'matric_no' => $data['matric_no'],
            'password' => Hash::make($data['password']),
            'faculty_id' => $faculty->faculty_id,
            'dept_id' => $department->dept_id,
        ]);
    }
}
