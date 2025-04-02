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
