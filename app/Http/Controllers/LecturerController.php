<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class LecturerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:lecturer,admin']);
    }

    public function dashboard()
    {
        $user = Auth::user();
        $courses = $user->createdCourses;
        
        // Course statistics
        $publishedCourses = $courses->where('is_published', true)->count();
        $draftCourses = $courses->where('is_published', false)->count();
        
        // Enrollment statistics
        $totalEnrollments = 0;
        foreach ($courses as $course) {
            $totalEnrollments += $course->enrollments->count();
        }
        
        return view('lecturer.dashboard', compact(
            'user', 
            'courses', 
            'publishedCourses', 
            'draftCourses', 
            'totalEnrollments'
        ));
    }

    public function courses()
    {
        $courses = Auth::user()->createdCourses()->latest()->paginate(10);
        return view('lecturer.courses', compact('courses'));
    }

    public function students()
    {
        $courses = Auth::user()->createdCourses()
            ->with(['enrollments.user'])
            ->latest()
            ->get();
            
        return view('lecturer.students', compact('courses'));
    }

}
