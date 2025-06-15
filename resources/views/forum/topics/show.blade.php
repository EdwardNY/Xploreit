@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4">
        <a href="{{ route('courses.show', [$course, $topic]) }}" class="text-decoration-none">
            <i class="fas fa-arrow-left"></i> Back to Course
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                @if($topic->is_pinned)
                    <span class="badge bg-primary me-1" title="Pinned Topic">
                        <i class="fas fa-thumbtack"></i>
                    </span>
                @endif
                @if($topic->is_locked)
                    <span class="badge bg-secondary me-1" title="Locked Topic">
                        <i class="fas fa-lock"></i>
                    </span>
                @endif
                <span class="h4">{{ $topic->title }}</span>
            </div>
            <div>
                @can('update', $topic)
                    <a href="{{ route('topics.edit', $topic) }}" class="btn btn-sm btn-outline-primary me-1">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endcan
                @can('pin', $topic)
                    <form action="{{ route('toggle-pin', ['course' => $course, 'topic' => $topic]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-outline-primary me-1">
                            <i class="fas fa-thumbtack"></i> {{ $topic->is_pinned ? 'Unpin' : 'Pin' }}
                        </button>
                    </form>
                @endcan
                @can('lock', $topic)
                    <form action="{{ route('toggle-lock', ['course' => $course, 'topic' => $topic]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-outline-secondary me-1">
                            <i class="fas {{ $topic->is_locked ? 'fa-unlock' : 'fa-lock' }}"></i> {{ $topic->is_locked ? 'Unlock' : 'Lock' }}
                        </button>
                    </form>
                @endcan
                @can('delete', $topic)
                    <form action="{{ route('topics.destroy', ['course' => $course, 'topic' => $topic]) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this topic?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                @endcan
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex mb-3">
                <div class="text-center me-3">
                    <div class="avatar-circle">
                        {{ substr($topic->user->name, 0, 1) }}
                    </div>
                    <div class="mt-1">{{ $topic->user->name }}</div>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">Posted {{ $topic->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="topic-content mt-2">
                        {!! nl2br(e($topic->content)) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h4 class="mb-3">Replies ({{ $replies->total() }})</h4>

    @if($replies->count() > 0)
        <div class="mb-4">
            @foreach($replies as $reply)
                <div class="card mb-3 {{ $reply->is_solution ? 'border-success' : '' }}">
                    <div class="card-header d-flex justify-content-between align-items-center {{ $reply->is_solution ? 'bg-success text-white' : 'bg-light' }}">
                        <div>
                            @if($reply->is_solution)
                                <i class="fas fa-check-circle me-1"></i> Solution
                            @else
                                <span>Reply</span>
                            @endif
                        </div>
                        <div>
                            @can('update', $reply)
                                <a href="{{ route('replies.edit', ['course' => $course, 'topic' => $topic, 'reply' => $reply]) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endcan
                            @can('markAsSolution', $reply)
                                <form action="{{ route('replies.toggle-solution', ['course' => $course, 'topic' => $topic, 'reply' => $reply]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-success me-1">
                                        <i class="fas fa-check-circle"></i> {{ $reply->is_solution ? 'Unmark Solution' : 'Mark as Solution' }}
                                    </button>
                                </form>
                            @endcan
                            @can('delete', $reply)
                                <form action="{{ route('forum.replies.destroy', ['course' => $course, 'topic' => $topic, 'reply' => $reply]) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this reply?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="text-center me-3">
                                <div class="avatar-circle">
                                    {{ substr($reply->user->name, 0, 1) }}
                                </div>
                                <div class="mt-1">{{ $reply->user->name }}</div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">Posted {{ $reply->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="reply-content mt-2">
                                    {!! nl2br(e($reply->content)) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($reply->childReplies && $reply->childReplies->count() > 0)
                        <div class="card-footer bg-light">
                            <h6>Comments</h6>
                            @foreach($reply->childReplies as $childReply)
                                <div class="border-top pt-3 pb-3">
                                    <div class="d-flex">
                                        <div class="text-center me-3">
                                            <div class="avatar-circle small">
                                                {{ substr($childReply->user->name, 0, 1) }}
                                            </div>
                                            <div class="mt-1 small">{{ $childReply->user->name }}</div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between">
                                                <small class="text-muted">{{ $childReply->created_at->diffForHumans() }}</small>
                                                <div>
                                                    @can('update', $childReply)
                                                        <a href="{{ route('forum.replies.edit', ['course' => $course, 'topic' => $topic, 'reply' => $childReply]) }}" class="btn btn-sm btn-link text-primary">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                    @endcan
                                                    @can('delete', $childReply)
                                                        <form action="{{ route('forum.replies.destroy', ['course' => $course, 'topic' => $topic, 'reply' => $childReply]) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-link text-danger">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </div>
                                            <div class="reply-content">
                                                {!! nl2br(e($childReply->content)) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @if(!$topic->is_locked)
                                <div class="mt-3">
                                    <!-- Preview Mode for Child Reply -->
                                    <div id="child-preview-{{ $reply->id }}">
                                        <div class="border rounded p-3 bg-light text-muted" style="min-height: 60px; cursor: pointer;" onclick="showChildReplyForm({{ $reply->id }})">
                                            <i class="fas fa-comment me-2"></i>Click to write a comment...
                                        </div>
                                    </div>

                                    <!-- Edit Mode for Child Reply -->
                                    <div id="child-edit-{{ $reply->id }}" style="display: none;">
                                        <form action="{{ route('forum.replies.store', ['course' => $course, 'topic' => $topic]) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="parent_id" value="{{ $reply->id }}">
                                            <div class="form-group">
                                                <textarea name="content" rows="2" class="form-control" placeholder="Write a comment..."></textarea>
                                            </div>
                                            <div class="mt-2 text-end">
                                                <button type="button" class="btn btn-sm btn-secondary me-1" onclick="hideChildReplyForm({{ $reply->id }})">Cancel</button>
                                                <button type="submit" class="btn btn-sm btn-primary">Add Comment</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if(!$topic->is_locked && !$reply->parent_id)
                        <div class="card-footer bg-light">
                            <button class="btn btn-sm btn-link text-primary reply-toggle" data-reply-id="{{ $reply->id }}">
                                <i class="fas fa-reply"></i> Comment
                            </button>
                            <div class="reply-form mt-2 d-none" id="reply-form-{{ $reply->id }}">
                                <!-- Preview Mode for Reply -->
                                <div id="reply-preview-{{ $reply->id }}">
                                    <div class="border rounded p-3 bg-light text-muted" style="min-height: 60px; cursor: pointer;" onclick="showReplyForm({{ $reply->id }})">
                                        <i class="fas fa-comment me-2"></i>Click to write your comment...
                                    </div>
                                </div>

                                <!-- Edit Mode for Reply -->
                                <div id="reply-edit-{{ $reply->id }}" style="display: none;">
                                    <form action="{{ route('replies.store', ['course' => $course, 'topic' => $topic]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $reply->id }}">
                                        <div class="form-group">
                                            <textarea name="content" rows="2" class="form-control" placeholder="Write your comment..."></textarea>
                                        </div>
                                        <div class="mt-2 text-end">
                                            <button type="button" class="btn btn-sm btn-secondary me-1" onclick="hideReplyForm({{ $reply->id }})">Cancel</button>
                                            <button type="submit" class="btn btn-sm btn-primary">Post Comment</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $replies->links() }}
        </div>
    @else
        <div class="alert alert-info">
            No replies yet. Be the first to reply!
        </div>
    @endif

    @if(!$topic->is_locked)
        <div class="card mt-4">
            <div class="card-header">
                <h5>Post a Reply</h5>
            </div>
            <div class="card-body">
                <!-- Preview Mode for Main Reply -->
                <div id="main-reply-preview">
                    <div class="border rounded p-4 bg-light text-muted" style="min-height: 120px; cursor: pointer;" onclick="showMainReplyForm()">
                        <i class="fas fa-edit me-2"></i>Click to write your reply...
                    </div>
                    <div class="mt-3">
                        <button type="button" class="btn btn-primary" onclick="showMainReplyForm()">Write Reply</button>
                    </div>
                </div>

                <!-- Edit Mode for Main Reply -->
                <div id="main-reply-edit" style="display: none;">
                    <form action="{{ route('replies.store', ['course' => $course, 'topic' => $topic]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <div class="form-group">
                            <textarea
                            name="content"
                            rows="5"
                            class="form-control @error('content') is-invalid @enderror"
                            placeholder="Write your reply..."
                            style="background-color: #ffffff !important; color: #333333 !important; font-size: 14px !important; line-height: 1.6 !important; padding: 12px !important;"
                        >{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Post Reply</button>
                            <button type="button" class="btn btn-secondary ms-2" onclick="hideMainReplyForm()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning mt-4">
            <i class="fas fa-lock me-2"></i> This topic is locked. No new replies can be posted.
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle reply forms
        document.querySelectorAll('.reply-toggle').forEach(function(button) {
            button.addEventListener('click', function() {
                const replyId = this.getAttribute('data-reply-id');
                document.getElementById('reply-form-' + replyId).classList.toggle('d-none');
            });
        });

        // Cancel reply
        document.querySelectorAll('.cancel-reply').forEach(function(button) {
            button.addEventListener('click', function() {
                const replyId = this.getAttribute('data-reply-id');
                document.getElementById('reply-form-' + replyId).classList.add('d-none');
            });
        });

        // Show edit mode if there are validation errors
        @if($errors->any())
            showMainReplyForm();
        @endif
    });

    // Main reply form functions
    function showMainReplyForm() {
        document.getElementById('main-reply-preview').style.display = 'none';
        document.getElementById('main-reply-edit').style.display = 'block';
        document.querySelector('#main-reply-edit textarea').focus();
    }

    function hideMainReplyForm() {
        document.getElementById('main-reply-edit').style.display = 'none';
        document.getElementById('main-reply-preview').style.display = 'block';
    }

    // Reply form functions
    function showReplyForm(replyId) {
        document.getElementById('reply-preview-' + replyId).style.display = 'none';
        document.getElementById('reply-edit-' + replyId).style.display = 'block';
        document.querySelector('#reply-edit-' + replyId + ' textarea').focus();
    }

    function hideReplyForm(replyId) {
        document.getElementById('reply-edit-' + replyId).style.display = 'none';
        document.getElementById('reply-preview-' + replyId).style.display = 'block';
    }

    // Child reply form functions
    function showChildReplyForm(replyId) {
        document.getElementById('child-preview-' + replyId).style.display = 'none';
        document.getElementById('child-edit-' + replyId).style.display = 'block';
        document.querySelector('#child-edit-' + replyId + ' textarea').focus();
    }

    function hideChildReplyForm(replyId) {
        document.getElementById('child-edit-' + replyId).style.display = 'none';
        document.getElementById('child-preview-' + replyId).style.display = 'block';
    }
</script>
@endpush

@endsection
