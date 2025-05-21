<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentLogController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\MentorSignatureController;
use App\Http\Controllers\TeacherNotesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/req', [MentorController::class, 'req'])->name('req');
Route::post('/req', [MentorController::class, 'store'])->name('confirms.store');
Route::put('/confirms/update', [MentorController::class, 'update'])->name('confirms.update');

Route::post('/approve-mentor', [AdminController::class, 'approveMentor'])->name('approve.mentor');

// Route for updating mentor signature
Route::post('/mentor/signature/update/{id?}', [MentorSignatureController::class, 'update'])->name('mentor.signature.update');
Route::post('/mentor/signature/update', [MentorSignatureController::class, 'update'])->name('mentor.signature.update');

Route::post('/mentor/comment/update', [MentorController::class, 'updateComment'])->name('mentor.comment.update');

// Route for updating teacher comments
Route::post('/teacher/comment/update', [StudentLogController::class, 'updateTeacherComment'])->name('teacher.comment.update');

// Route for updating mentor comments
Route::post('/mentor/comment/update', [StudentLogController::class, 'updateMentorComment'])->name('mentor.comment.update');

Route::group(['prefix' => 'location'], function () {
    Route::get('index', [LocationController::class, 'index'])->name('location.index');
    Route::post('addstore', [LocationController::class, 'store'])->name('location.store');
    Route::post('/register-advisor', [LocationController::class, 'registerAdvisor'])->name('location.registerAdvisor');
    Route::post('/cancel-advisor', [LocationController::class, 'cancelAdvisor'])->name('location.cancelAdvisor');
    Route::put('/update/{id}', [LocationController::class, 'update'])->name('location.update'); // Added route for updating locations
});

Route::group(['prefix' => 'student'], function () {
    Route::get('index', [StudentController::class, 'index'])->name('student.index');
    Route::post('/upload-image', [StudentController::class, 'uploadImage'])->name('student.uploadImage');
});

Route::post('/student/upload-image', [StudentController::class, 'uploadImage'])->name('student.uploadImage');

Route::get('/create-student-images-folder', function () {
    $path = public_path('student_images');
    if (!File::exists($path)) {
        File::makeDirectory($path, 0755, true);
    }
    return 'Folder created successfully!';
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::group(['prefix' => 'edit'], function () {
        Route::get('users', [AdminController::class, 'users'])->name('user.index');
    Route::post('update-role', [AdminController::class, 'edit'])->name('users.updateRole');
    Route::post('update-status', [AdminController::class, 'updateStatus'])->name('users.updateStatus');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/student/log', [StudentLogController::class, 'index'])->name('student.log');
    Route::post('/student/log', [StudentLogController::class, 'store'])->name('student.log.store');
    Route::put('/student/log/update', [StudentLogController::class, 'update'])->name('student.log.update');
    Route::get('/teacher', [TeacherController::class, 'index'])->name('teacher.index');
});

Route::middleware(['auth', 'role:Teacher'])->group(function () {
    Route::get('/teacher/notes', [TeacherNotesController::class, 'index'])->name('teacher.notes');
    Route::post('/teacher/notes', [TeacherNotesController::class, 'store'])->name('teacher.notes.store');
    Route::get('/teacher/notes/edit/{student_id}', [TeacherNotesController::class, 'edit'])->name('teacher.notes.edit');
    Route::put('/teacher/notes/update/{student_id}', [TeacherNotesController::class, 'update'])->name('teacher.notes.update');
});

Route::get('student/log/{student_id}', [StudentLogController::class, 'show'])->name('student.log.show');

Route::get('/teacher/add-note/{studentId}', [App\Http\Controllers\TeacherController::class, 'addNote'])->name('teacher.addNote');
