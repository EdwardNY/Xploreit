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
Route::resource('courses', App\Http\Controllers\CourseController::class);


Route::get('/', function () {
    return view('welcome');
});


Route::get('/topics', [App\Http\Controllers\ForumTopicController::class, 'index'])->name('topics.index');
//Route::get('/topics/create/', [App\Http\Controllers\ForumTopicController::class, 'create'])->name('topics.create');
Route::get('/topics/create/{course}', [App\Http\Controllers\ForumTopicController::class, 'create'])->name('topics.create');
Route::post('/topics', [App\Http\Controllers\ForumTopicController::class, 'store'])->name('topics.store');
Route::get('/topics/{topic}/edit', [App\Http\Controllers\ForumTopicController::class, 'edit'])->name('topics.edit');
Route::get('/topics/{course}/{topic}', [App\Http\Controllers\ForumTopicController::class, 'show'])->name('topics.show');
Route::put('/topics/{topic}', [App\Http\Controllers\ForumTopicController::class, 'update'])->name('topics.update');
Route::delete('/topics/{topic}', [App\Http\Controllers\ForumTopicController::class, 'destroy'])->name('topics.destroy');
Route::patch('/topics/{topic}/pin', [App\Http\Controllers\ForumTopicController::class, 'togglePin'])->name('toggle-pin');
Route::patch('/topics/{topic}/lock', [App\Http\Controllers\ForumTopicController::class, 'toggleLock'])->name('toggle-lock');

// Route::get('/topics/{course}', [App\Http\Controllers\ForumTopicController::class, 'index'])->name('topics.index');
// Route::get('/topics/create/{course}', [App\Http\Controllers\ForumTopicController::class, 'create'])->name('topics.create');
// Route::post('/topics/{course}', [App\Http\Controllers\ForumTopicController::class, 'store'])->name('topics.store');
// Route::get('/topics/{course}/{topic}', [App\Http\Controllers\ForumTopicController::class, 'show'])->name('topics.show');
// Route::get('/topics/{course}/{topic}/edit', [App\Http\Controllers\ForumTopicController::class, 'edit'])->name('topics.edit');
// Route::put('/topics/{course}/{topic}', [App\Http\Controllers\ForumTopicController::class, 'update'])->name('topics.update');
// Route::delete('/topics/{course}/{topic}', [App\Http\Controllers\ForumTopicController::class, 'destroy'])->name('topics.destroy');
// Route::patch('/topics/{course}/{topic}/pin', [App\Http\Controllers\ForumTopicController::class, 'togglePin'])->name('toggle-pin');
// Route::patch('/topics/{course}/{topic}/lock', [App\Http\Controllers\ForumTopicController::class, 'toggleLock'])->name('toggle-lock');

// Replies
Route::post('/topics/{topic}/replies', [App\Http\Controllers\ForumReplyController::class, 'store'])->name('replies.store');
Route::get('/topics/{topic}/replies/{reply}/edit', [App\Http\Controllers\ForumReplyController::class, 'edit'])->name('replies.edit');
Route::put('/topics/{topic}/replies/{reply}', [App\Http\Controllers\ForumReplyController::class, 'update'])->name('replies.update');
Route::delete('/topics/{topic}/replies/{reply}', [App\Http\Controllers\ForumReplyController::class, 'destroy'])->name('forum.replies.destroy');
Route::patch('/topics/{topic}/replies/{reply}/solution', [App\Http\Controllers\ForumReplyController::class, 'toggleSolution'])->name('replies.toggle-solution');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/courses', [App\Http\Controllers\CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/create', [App\Http\Controllers\CourseController::class, 'create'])->name('courses.create');
Route::post('/courses', [App\Http\Controllers\CourseController::class, 'store'])->name('courses.store');
Route::get('/courses/{course}', [App\Http\Controllers\CourseController::class, 'show'])->name('courses.show');
Route::get('/courses/{course}/edit', [App\Http\Controllers\CourseController::class, 'edit'])->name('courses.edit');
Route::put('/courses/{course}', [App\Http\Controllers\CourseController::class, 'update'])->name('courses.update');
Route::delete('/courses/{course}', [App\Http\Controllers\CourseController::class, 'destroy'])->name('courses.destroy');

Route::get('/courses/{course}/videos/create', [App\Http\Controllers\VideoController::class, 'create'])->name('videos.create');
Route::post('/courses/{course}/videos', [App\Http\Controllers\VideoController::class, 'store'])->name('videos.store');
Route::get('/courses/{course}/videos/{video}', [App\Http\Controllers\VideoController::class, 'show'])->name('videos.show');
Route::get('/courses/{course}/videos/{video}/edit', [App\Http\Controllers\VideoController::class, 'edit'])->name('videos.edit');
Route::put('/courses/{course}/videos/{video}', [App\Http\Controllers\VideoController::class, 'update'])->name('videos.update');
Route::delete('/courses/{course}/videos/{video}', [App\Http\Controllers\VideoController::class, 'destroy'])->name('videos.destroy');

Route::get('/my-courses', [App\Http\Controllers\EnrollmentController::class, 'index'])->name('enrollments.index');
Route::post('/courses/{course}/enroll', [App\Http\Controllers\EnrollmentController::class, 'store'])->name('enrollments.store');
Route::delete('/courses/{course}/enrollments/{enrollment}', [App\Http\Controllers\EnrollmentController::class, 'destroy'])->name('enrollments.destroy');
Route::get('/courses/{course}/students', [App\Http\Controllers\EnrollmentController::class, 'showEnrolledStudents'])->name('courses.enrolled-students');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/change-password', [App\Http\Controllers\ProfileController::class, 'changePassword'])->name('profile.change-password');
});

Route::middleware(['auth', 'role:lecturer,admin'])->prefix('lecturer')->name('lecturer.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\LecturerController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [App\Http\Controllers\LecturerController::class, 'courses'])->name('courses');
    Route::get('/students', [App\Http\Controllers\LecturerController::class, 'students'])->name('students');
});

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [App\Http\Controllers\StudentController::class, 'courses'])->name('courses');
});


