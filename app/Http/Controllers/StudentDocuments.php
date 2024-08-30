<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class StudentDocuments extends Controller
{

    function view_student_document(Request $request)
    {

        $documents = DB::table('filetypes')
            ->where('id', $request->documentId)
            ->first();

        $file = DB::table('student_uploads')
            ->where('document_id', $request->documentId)
            ->where('student_id', auth()->id())
            ->first();


        return view('documents.fileUpload', compact('documents', 'file'));
    }


    public function upload_document(Request $request)
    {
        try {
            //step 1: validate request
            $request->validate([
                'document_file' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048', // Max file size set to 2MB
                'documentId' => 'required|integer',
            ]);


            $studentId = auth()->id(); //get currently logged in studentId
            $documentId = $request->documentId;


            // Step 2: Store the uploaded file in the 'public/uploads' directory
            $fileName = time() . '_' . $request->file('document_file')->getClientOriginalName();
            $path = $request->file('document_file')->move(public_path('uploads'), $fileName);

            //step3: check if the document already exists for that student/insert the record into the db
            $existingDocument = DB::table('student_uploads')
                ->where('student_id', $studentId)
                ->where('document_id', $documentId)
                ->count();

            if ($existingDocument == 0) {
                //step 4: insert the record into the db
                DB::table('student_uploads')->insert([
                    'student_id' => $studentId,
                    'document_id' => $documentId,
                    'document_path' => 'uploads/' . $fileName,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                DB::table('student_uploads')
                    ->where('student_id', $studentId)
                    ->where('document_id', $documentId)
                    ->update([
                        'document_path' => 'uploads/' . $fileName,
                    ]);
            }

            //return a message
            return redirect()->back()->with('success', 'Document uploaded successfully!')->with('filePath', 'uploads/' . $fileName);
        } catch (\Exception $e) {
            // Log the error message
            \Log::error('File upload failed: ' . $e->getMessage());

            // Return an error message
            return redirect()->back()->withErrors(['error' => 'File upload failed. Please try again.']);
        }
    }

    public function final_submission()
    {
        $studentId = auth()->id();

        //check if the student exists in the db
        $check = DB::table('document_status')
            ->where('student_id', $studentId)
            ->count();
        if ($check == 0) {
            DB::table('document_status')->insert([
                'student_id' => $studentId,
                'status' => '1'
            ]);
        } else {
            DB::table('document_status')->update([
                'status' => '1'
            ]);
        }

        return redirect()->back()->with('success', 'All Documents submitted successfully!');
    }
}
