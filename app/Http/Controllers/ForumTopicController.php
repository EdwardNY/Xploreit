<?php

namespace App\Http\Controllers;

use App\Models\ForumTopic;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumTopicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Course $course)
    {
        $topics = $course->forumTopics()
            ->orderBy('is_pinned', 'desc')
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('forum.topics.index', compact('course', 'topics'));
    }

    public function show(Course $course, ForumTopic $topic)
    {
        $replies = $topic->rootReplies()
            ->with(['user', 'childReplies.user'])
            ->orderBy('created_at')
            ->paginate(15);

        return view('forum.topics.show', compact('course', 'topic', 'replies'));
    }

    // public function create(Request $request)
    // {
    //     $courseId = $request->get('course_id'); // Get from URL parameter
    //     $course = Course::findOrFail($courseId);

    //     $this->authorize('create', [ForumTopic::class, $course]);
    //     return view('forum.topics.create', compact('course'));
    // }

    public function create(Course $course)
    {
        $this->authorize('create', [ForumTopic::class, $course]);
        return view('forum.topics.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'course_id' => 'required|exists:courses,id'
        ]);
        $course = Course::findOrFail($validated['course_id']);
        $this->authorize('create', [ForumTopic::class, $course]);

        $topic = new ForumTopic([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => Auth::id(),
            'course_id' => $validated['course_id']
        ]);

        $topic->save();

        return redirect()->route('topics.show', ['course' => $course, 'topic' => $topic])
            ->with('success', 'Topic created successfully!');
    }

    public function edit(Course $course, ForumTopic $topic)
    {
        $course = $topic->course;
        $this->authorize('update', $topic);
        return view('forum.topics.edit', compact('course', 'topic'));
    }

    public function update(Request $request, Course $course, ForumTopic $topic)
    {
        $course = $topic->course;
        $this->authorize('update', $topic);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $topic->update([
            'title' => $validated['title'],
            'content' => $validated['content']
        ]);

        return redirect()->route('topics.show', ['course' => $course, 'topic' => $topic])
            ->with('success', 'Topic updated successfully!');
    }

    public function destroy(Course $course, ForumTopic $topic)
    {
        $this->authorize('delete', $topic);

        $topic->delete();

        return redirect()->route('topics.index', $course)
            ->with('success', 'Topic deleted successfully!');
    }

    public function togglePin(Course $course, ForumTopic $topic)
    {
        $this->authorize('pin', $topic);

        $topic->update([
            'is_pinned' => !$topic->is_pinned
        ]);

        return back()->with('success', $topic->is_pinned ? 'Topic pinned successfully!' : 'Topic unpinned successfully!');
    }

    public function toggleLock(Course $course, ForumTopic $topic)
    {
        $this->authorize('lock', $topic);

        $topic->update([
            'is_locked' => !$topic->is_locked
        ]);

        return back()->with('success', $topic->is_locked ? 'Topic locked successfully!' : 'Topic unlocked successfully!');
    }
}
