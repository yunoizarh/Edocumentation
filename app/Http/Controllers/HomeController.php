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

        return view('home', compact('documents', 'finalSubmission', 'submittedRecords'));
    }
}
