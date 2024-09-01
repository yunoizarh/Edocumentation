<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $documents = DB::table("filetypes")
            ->get();

        $finalSubmission = DB::table('document_status')
            ->where('student_id', auth()->id())
            ->where('status', '1')
            ->count();

        $submittedRecords = DB::table('student_uploads')
            ->where('student_id', auth()->id())
            ->pluck('document_id',)
            ->toArray();

        $studentDept = DB::table('users')
            ->where('users.id', auth()->id())
            ->join('departments', 'users.dept_id', '=', 'departments.dept_id')
            ->select('users.*', 'departments.dept_title')
            ->first();

        $profileImage = DB::table('student_uploads')
            ->where('student_id', auth()->id())
            ->join('filetypes', 'filetypes.id', '=', 'student_uploads.document_id')
            ->where('filetypes.id', 7)
            ->value('student_uploads.document_path');

        // Set the default image if the passport is not uploaded
        $profileImage = $profileImage ?? 'images/avatar/2.jpg';

        $studentNotifications = DB::table('document_status')
            ->where('student_id', auth()->id())
            ->first();
        return view('home', compact('documents', 'finalSubmission', 'submittedRecords', 'studentDept', 'profileImage', 'studentNotifications'));
    }
}
