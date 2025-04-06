<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Course $course)
    {
        $this->authorize('create', [Enrollment::class, $course]);
        
        // Create the enrollment
        $enrollment = new Enrollment([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'enrolled_at' => now()
        ]);
        
        $enrollment->save();
        
        return redirect()->route('courses.show', $course)
            ->with('success', 'You have successfully enrolled in this course!');
    }

    public function destroy(Course $course, Enrollment $enrollment)
    {
        $this->authorize('delete', $enrollment);
        
        $enrollment->delete();
        
        return redirect()->route('courses.index')
            ->with('success', 'You have successfully unenrolled from this course.');
    }

    public function showEnrolledStudents(Course $course)
    {
        $this->authorize('viewEnrolledStudents', [Enrollment::class, $course]);
        
        $enrolledStudents = $course->enrollments()
            ->with('user')
            ->orderBy('enrolled_at', 'desc')
            ->paginate(20);
            
        return view('courses.enrollments.index', compact('course', 'enrolledStudents'));
    }

    public function index()
    {
        // Show enrolled courses for the current user
        $enrollments = Auth::user()->enrollments()
            ->with('course')
            ->orderBy('enrolled_at', 'desc')
            ->paginate(12);
            
        return view('enrollments.index', compact('enrollments'));
    }
}