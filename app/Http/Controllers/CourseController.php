<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:lecturer'])->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::where('is_published', true)->paginate(10);
        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('course_thumbnails', 'public');
        }

        $course = Course::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'lecturer_id' => Auth::id(),
            'thumbnail' => $thumbnailPath,
            'is_published' => $request->has('is_published')
        ]);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Course created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::with(['videos', 'forumTopics.user'])->findOrFail($id);

        if ($course->is_published || (Auth::check() && Auth::id() === $course->lecturer_id)) {
            $isLecturer = Auth::check() && Auth::id() === $course->lecturer_id;

            return view('courses.show', compact('course', 'isLecturer'));
        }

        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $this->authorize('update', $course);

        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $this->authorize('update', $course);

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'nullable' // Add validation for is_published
        ]);

        // Handle thumbnail update
        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }

            $thumbnailPath = $request->file('thumbnail')->store('course_thumbnails', 'public');
            $validatedData['thumbnail'] = $thumbnailPath;
        }

        // Explicitly handle the is_published checkbox
        // Convert to boolean: 1 if checked, 0 if unchecked
        $validatedData['is_published'] = $request->input('is_published') == '1' ? 1 : 0;

        $course->update($validatedData);

        // Debug: Add this temporarily to check the value
        // dd($validatedData['is_published'], $course->fresh()->is_published);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Course updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $this->authorize('delete', $course);

        // Delete thumbnail if exists
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully');

    }

}
