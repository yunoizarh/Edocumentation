<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class studentFilesController extends Controller
{
    public function getSubmittedFiles(Request $request)
    {
        $getFiles = DB::table('student_uploads')
            ->where("student_id", $request->student_id)
            ->leftjoin('filetypes', 'student_uploads.document_id', 'filetypes.id')
            ->select('filetypes.file_name', 'student_uploads.document_path', 'student_uploads.updated_at')
            ->get();

        return response()->json(["getFiles" => $getFiles]);
    }

    public function approve_Documents(Request $request)
    {
        DB::table('document_status')
            ->where('student_id', $request->student_id)
            ->update([
                'status' => '2'
            ]);

        return response()->json(["status" => "successful"]);
    }

    public function reject_documents(Request $request)
    {

        DB::table('document_status')
            ->where('student_id', $request->student_id)
            ->update([
                'comment' => $request->comment,
                'status' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        return redirect()->back()->with('success', 'Comment sent successfully');
    }
}
