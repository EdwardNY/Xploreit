<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:student']);
    }

    public function dashboard()
    {
        $user = Auth::user();
        $enrollments = $user->enrollments()->with('course')->latest()->take(5)->get();
        
        return view('student.dashboard', compact('user', 'enrollments'));
    }

    public function courses()
    {
        $enrollments = Auth::user()->enrollments()
            ->with('course')
            ->latest()
            ->paginate(12);
            
        return view('student.courses', compact('enrollments'));
    }

}
