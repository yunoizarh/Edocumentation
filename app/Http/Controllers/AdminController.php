<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            Auth::guard('admin')->login($admin);
            return redirect()->route('admin.dashboard');
        } else {
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }
    }

    public function dashboard()
    {
        // Retrieve the logged-in admin user
        $loggedInAdmin = Auth::guard('admin')->user();
        $recentlySubmitted = [];

        // Case 1: Super Admin - No Faculty or Department assigned
        if ($loggedInAdmin->faculty_id == 0 && $loggedInAdmin->dept_id == 0) {
            $recentlySubmitted = DB::table('document_status')
                ->join('users', 'document_status.student_id', '=', 'users.id')
                ->where('status', '1')
                ->get();
        }
        // Case 2: Faculty Admin - Load only faculty student files
        elseif ($loggedInAdmin->faculty_id != null) {
            $recentlySubmitted = DB::table('document_status')
                ->join('users', 'document_status.student_id', '=', 'users.id')
                ->where('status', '1')
                ->where('users.faculty_id', $loggedInAdmin->faculty_id)
                ->get();
        }
        // Case 3: Department Admin - Load department student files
        elseif ($loggedInAdmin->dept_id != null) {
            $recentlySubmitted = DB::table('document_status')
                ->join('users', 'document_status.student_id', '=', 'users.id')
                ->where('status', '1')
                ->where('users.dept_id', $loggedInAdmin->dept_id)
                ->get();
        }

        // Return the view with the recently submitted documents
        return view('admin.dashboard', compact('recentlySubmitted'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function manage_staff()
    {
        $depts = DB::table('departments')
            ->get();

        $staffs = DB::table('admins')
            ->where('admins.dept_id', '!=', '0') // Specify the table explicitly
            ->join('departments', 'admins.dept_id', '=', 'departments.dept_id')
            ->leftjoin('faculty', 'admins.faculty_id', '=', 'faculty.faculty_id')
            ->select('admins.*', 'departments.dept_title', 'faculty.faculty_code')
            ->get();

        $faculties = DB::table('faculty')
            ->get();

        return view('admin.manageStaff', compact('depts', 'staffs', 'faculties'));
    }

    public function Add_staff(Request $request)
    {
        DB::table('admins')
            ->insert([
                'name' => $request->fullname,
                'email' => $request->email,
                'password' => Hash::make($request->phone),
                'dept_id' => $request->dept,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        return redirect()->back()->with('success', 'Staff Added Successfully');
    }

    public function assign_faculty_to_staff(Request $request)
    {
        DB::table('admins')
            ->where('id', $request->staffId)
            ->update([
                'faculty_id' => $request->faculty_id,
                'updated_at' => now(),
            ]);

        return response()->json(["status" => "successful"]);
    }

    public function De_assign_faculty(Request $request)
    {
        DB::table('admins')
            ->where('id', $request->staffId)
            ->update([
                'faculty_id' => null,
                'updated_at' => now()
            ]);

        return response()->json(['status' => 'successful']);
    }

    public function manage_students()
    {
        $students = DB::table('users')
            ->join('departments', 'users.dept_id', 'departments.dept_id')
            ->select('users.*', 'departments.dept_title')
            ->get();

        return view('admin.manageStudents', compact('students'));
    }

    public function view_students_documents(Request $request)
    {
        $studentDocs =  DB::table('student_uploads')
            ->where('student_id', $request->student_id)
            ->join('filetypes', 'student_uploads.document_id', '=', 'filetypes.id')
            ->select('student_uploads.*', 'filetypes.file_name')
            ->get();

        return response()->json(['studentDocs' => $studentDocs]);
    }
}
