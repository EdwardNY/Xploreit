<?php

namespace App\Http\Controllers;

use App\Models\ForumReply;
use App\Models\ForumTopic;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Course $course, ForumTopic $topic)
    {
        $this->authorize('create', [ForumReply::class, null, $topic->id]);

        $validated = $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:forum_replies,id',
            'course_id' => 'required|exists:courses,id'
        ]);

        $course = Course::findOrFail($validated['course_id']);

        $reply = new ForumReply([
            'content' => $validated['content'],
            'user_id' => Auth::id(),
            'forum_topic_id' => $topic->id,
            'parent_id' => $validated['parent_id'] ?? null
        ]);

        $reply->save();

        return redirect()->route('topics.show', ['course' => $course, 'topic' => $topic])
            ->with('success', 'Reply posted successfully!');
    }

    public function edit(Course $course, ForumTopic $topic, ForumReply $reply)
    {
        $this->authorize('update', $reply);
        return view('forum.replies.edit', compact('course', 'topic', 'reply'));
    }

    public function update(Request $request, Course $course, ForumTopic $topic, ForumReply $reply)
    {
        $this->authorize('update', $reply);

        $validated = $request->validate([
            'content' => 'required|string'
        ]);

        $reply->update([
            'content' => $validated['content']
        ]);

        return redirect()->route('forum.topics.show', ['course' => $course, 'topic' => $topic])
            ->with('success', 'Reply updated successfully!');
    }

    public function destroy(Course $course, ForumTopic $topic, ForumReply $reply)
    {
        $this->authorize('delete', $reply);

        $reply->delete();

        return redirect()->route('topics.show', ['course' => $course, 'topic' => $topic])
            ->with('success', 'Reply deleted successfully!');
    }

    public function toggleSolution(Course $course, ForumTopic $topic, ForumReply $reply)
    {
        $this->authorize('markAsSolution', $reply);

        // If this reply is being marked as solution, unmark any existing solution
        if (!$reply->is_solution) {
            ForumReply::where('forum_topic_id', $topic->id)
                ->where('is_solution', true)
                ->update(['is_solution' => false]);
        }

        $reply->update([
            'is_solution' => !$reply->is_solution
        ]);

        return back()->with('success', $reply->is_solution ? 'Reply marked as solution!' : 'Solution mark removed!');
    }
}
