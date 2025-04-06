<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::resource('courses', CourseController::class);


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/courses', [App\Http\Controllers\CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/create', [App\Http\Controllers\CourseController::class, 'create'])->name('courses.create');
Route::post('/courses', [App\Http\Controllers\CourseController::class, 'store'])->name('courses.store');
Route::get('/courses/{course}', [App\Http\Controllers\CourseController::class, 'show'])->name('courses.show');
Route::get('/courses/{course}/edit', [App\Http\Controllers\CourseController::class, 'edit'])->name('courses.edit');
Route::put('/courses/{course}', [App\Http\Controllers\CourseController::class, 'update'])->name('courses.update');
Route::delete('/courses/{course}', [App\Http\Controllers\CourseController::class, 'destroy'])->name('courses.destroy');

Route::get('/courses/{course}/videos/create', [VideoController::class, 'create'])->name('videos.create');
Route::post('/courses/{course}/videos', [VideoController::class, 'store'])->name('videos.store');
Route::get('/courses/{course}/videos/{video}', [VideoController::class, 'show'])->name('videos.show');
Route::get('/courses/{course}/videos/{video}/edit', [VideoController::class, 'edit'])->name('videos.edit');
Route::put('/courses/{course}/videos/{video}', [VideoController::class, 'update'])->name('videos.update');
Route::delete('/courses/{course}/videos/{video}', [VideoController::class, 'destroy'])->name('videos.destroy');

Route::prefix('courses/{course}/forum')->name('forum.')->group(function () {
    // Topics
    Route::get('/', [ForumTopicController::class, 'index'])->name('topics.index');
    Route::get('/topics/create', [ForumTopicController::class, 'create'])->name('topics.create');
    Route::post('/topics', [ForumTopicController::class, 'store'])->name('topics.store');
    Route::get('/topics/{topic}', [ForumTopicController::class, 'show'])->name('topics.show');
    Route::get('/topics/{topic}/edit', [ForumTopicController::class, 'edit'])->name('topics.edit');
    Route::put('/topics/{topic}', [ForumTopicController::class, 'update'])->name('topics.update');
    Route::delete('/topics/{topic}', [ForumTopicController::class, 'destroy'])->name('topics.destroy');
    Route::patch('/topics/{topic}/pin', [ForumTopicController::class, 'togglePin'])->name('topics.pin');
    Route::patch('/topics/{topic}/lock', [ForumTopicController::class, 'toggleLock'])->name('topics.lock');
    
    // Replies
    Route::post('/topics/{topic}/replies', [ForumReplyController::class, 'store'])->name('replies.store');
    Route::get('/topics/{topic}/replies/{reply}/edit', [ForumReplyController::class, 'edit'])->name('replies.edit');
    Route::put('/topics/{topic}/replies/{reply}', [ForumReplyController::class, 'update'])->name('replies.update');
    Route::delete('/topics/{topic}/replies/{reply}', [ForumReplyController::class, 'destroy'])->name('replies.destroy');
    Route::patch('/topics/{topic}/replies/{reply}/solution', [ForumReplyController::class, 'toggleSolution'])->name('replies.solution');
});

Route::get('/my-courses', [EnrollmentController::class, 'index'])->name('enrollments.index');
Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store'])->name('enrollments.store');
Route::delete('/courses/{course}/enrollments/{enrollment}', [EnrollmentController::class, 'destroy'])->name('enrollments.destroy');
Route::get('/courses/{course}/students', [EnrollmentController::class, 'showEnrolledStudents'])->name('courses.enrolled-students');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
});

Route::middleware(['auth', 'role:lecturer,admin'])->prefix('lecturer')->name('lecturer.')->group(function () {
    Route::get('/dashboard', [LecturerController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [LecturerController::class, 'courses'])->name('courses');
    Route::get('/students', [LecturerController::class, 'students'])->name('students');
});

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [StudentController::class, 'courses'])->name('courses');
});