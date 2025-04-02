<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Course $course)
    {
        $this->authorize('update', $course);
        return view('videos.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $this->authorize('update', $course);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'required|file|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:102400',
            'order' => 'integer|min:0',
            'is_preview' => 'boolean',
        ]);

        $videoPath = $request->file('video')->store('videos', 'public');

        // You might want to use a library like FFMpeg to get the duration
        // For now, we'll set it to 0 as a placeholder
        $duration = 0;

        $video = new Video([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'video_path' => $videoPath,
            'duration' => $duration,
            'order' => $validated['order'] ?? 0,
            'is_preview' => $validated['is_preview'] ?? false
        ]);

        $course->videos()->save($video);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Video uploaded successfully!');
    }

    public function edit(Course $course, Video $video)
    {
        $this->authorize('update', $course);
        return view('videos.edit', compact('course', 'video'));
    }

    public function update(Request $request, Course $course, Video $video)
    {
        $this->authorize('update', $course);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'integer|min:0',
            'is_preview' => 'boolean',
        ]);

        if ($request->hasFile('video')) {
            $request->validate([
                'video' => 'file|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:102400',
            ]);

            // Delete old video
            Storage::disk('public')->delete($video->video_path);
            
            // Store new video
            $videoPath = $request->file('video')->store('videos', 'public');
            $video->video_path = $videoPath;
        }

        $video->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? $video->description,
            'order' => $validated['order'] ?? $video->order,
            'is_preview' => $validated['is_preview'] ?? $video->is_preview,
        ]);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Video updated successfully!');
    }

    public function destroy(Course $course, Video $video)
    {
        $this->authorize('update', $course);
        
        // Delete the video file
        Storage::disk('public')->delete($video->video_path);
        
        // Delete the video record
        $video->delete();

        return redirect()->route('courses.show', $course)
            ->with('success', 'Video deleted successfully!');
    }

    public function show(Course $course, Video $video)
    {
        // Check if user is enrolled or if video is a preview
        if (!$video->is_preview) {
            $this->authorize('view', $course);
        }

        return view('videos.show', compact('course', 'video'));
    }
}