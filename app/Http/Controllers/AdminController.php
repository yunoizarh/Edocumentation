<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;

class AdminController extends Controller
{


    public function dashboard()
    {
        // Retrieve the logged-in admin user
        $adminSuper = DB::table('admins')->where('id', '1')->value('id');
        $loggedInAdmin = Auth::guard('admin')->user();
        $recentlySubmitted = [];

        // Case 1: Super Admin - No Faculty or Department assigned
        if ($adminSuper == $loggedInAdmin->id) {
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



    public function manage_staff()
    {
        $depts = DB::table('departments')
            ->get();

        $staffs = DB::table('admins')
            ->where('admins.id', '!=', '1')
            ->leftjoin('departments', 'admins.dept_id', '=', 'departments.dept_id')
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
                'phone_no' => $request->phone,
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
                'dept_id' => '0',
                'updated_at' => now(),
            ]);

        return response()->json(["status" => "successful"]);
    }


    function delete_staff(Request $request)
    {
        DB::table('admins')
            ->where('id', $request->staffId)
            ->delete();

        return response()->json(['status' => 'successful']);
    }

    public function edit_staff($id)
    {
        $staffRecords =  DB::table('admins')
            ->where('id', $id)
            ->first();

        return response()->json($staffRecords);
    }

    public function update_staff(Request $request)
    {

        $staff = DB::table('admins')
            ->where('id', $request->staff_id)
            ->select('faculty_id')
            ->first();

        $newDeptId = is_null($staff->faculty_id) ?  $request->dept : 0;

        DB::table('admins')
            ->where('id', $request->staff_id)
            ->update([
                'name' => $request->fullname,
                'email' => $request->email,
                'phone_no' => $request->phone,
                'password' => Hash::make($request->phone),
                'dept_id' => $newDeptId,
            ]);

        return redirect()->back()->with('success', 'Staff Details Updated Successfully');
    }


    public function De_assign_faculty(Request $request)
    {
        DB::table('admins')
            ->where('id', $request->staffId)
            ->update([
                'faculty_id' => null,
                'dept_id' => $request->deptId,
                'updated_at' => now()
            ]);

        return response()->json(['status' => 'successful']);
    }




    public function manage_students()
    {
        $adminSuper = DB::table('admins')->where('id', '1')->value('id');
        $loggedInAdminSuper = Auth::guard('admin')->user()->id;
        $loggedInAdminFac =  Auth::guard('admin')->user()->faculty_id;
        $loggedInAdminDept =  Auth::guard('admin')->user()->dept_id;

        if ($adminSuper == $loggedInAdminSuper) {
            $students = DB::table('users')
                ->join('departments', 'users.dept_id', 'departments.dept_id')
                ->select('users.*', 'departments.dept_title')
                ->get();
        } elseif ($loggedInAdminFac != null) {
            $students = DB::table('users')
                ->where('users.faculty_id', '=', $loggedInAdminFac)
                ->join('departments', 'users.dept_id', 'departments.dept_id')
                ->select('users.*', 'departments.dept_title')
                ->get();
        } else if ($loggedInAdminDept != null) {
            $students = DB::table('users')
                ->where('users.dept_id', '=', $loggedInAdminDept)
                ->join('departments', 'users.dept_id', 'departments.dept_id')
                ->select('users.*', 'departments.dept_title')
                ->get();
        }


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
