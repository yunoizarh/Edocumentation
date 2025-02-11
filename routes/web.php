<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentDocuments;
use App\Http\Controllers\AdminAuth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\studentFilesController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/view_student_document', [StudentDocuments::class, 'view_student_document'])->name('view_student_document');
Route::post('/upload_document', [StudentDocuments::class, 'upload_document'])->name('upload_document');
Route::post('/final_submission', [StudentDocuments::class, 'final_submission'])->name('final_submission');


//admin routes
Route::get('/Admin-login', [AdminAuth::class, 'showLoginForm'])->name('admin.login');
Route::post('/Admin-login', [AdminAuth::class, 'login']);

Route::middleware('auth:admin')->group(function () {
    Route::get('/Admin-dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/Admin-logout', [AdminAuth::class, 'logout'])->name('admin.logout');
    Route::post('/Admin-getSubmittedFiles', [studentFilesController::class, 'getSubmittedFiles'])->name('admin.getSubmittedFiles');
    Route::post('/Admin-approve-Documents', [studentFilesController::class, 'approve_Documents'])->name('admin.approve-Documents');
    Route::post('/Admin-reject-documents', [studentFilesController::class, 'reject_documents'])->name('admin.reject-documents');
    Route::get('/Admin-manage-staff', [AdminController::class, 'manage_staff'])->name('admin.manage-staff');
    Route::post('/Admin-Add-staff', [AdminController::class, 'Add_staff'])->name('admin.Add-staff');
    Route::post('/Admin-assign-faculty', [AdminController::class, 'assign_faculty_to_staff'])->name('admin.assign-faculty');
    Route::post('/Admin-Deassign-faculty', [AdminController::class, 'De_assign_faculty'])->name('admin.Deassign-faculty');
    Route::get('/admin-manage-students', [AdminController::class, 'manage_students'])->name('admin.manage-students');
    Route::post('/admin-view-students-documents', [AdminController::class, 'view_students_documents'])->name('admin.view-students-documents');
    Route::get('/admin-show-change-password', [AdminAuth::class, 'show_change_password'])->name('admin.show-change-password');
    Route::post('/admin-change-password', [AdminAuth::class, 'changePassword'])->name('admin.change-password');
    Route::post('/admin-delete-staff', [AdminController::class, 'delete_staff'])->name('admin.delete-staff');
    Route::get('/admin-edit-staff/{id}', [AdminController::class, 'edit_staff'])->name('admin.edit-staff');
    Route::post('/admin-update-staff', [AdminController::class, 'update_staff'])->name('admin.update-staff');
});
