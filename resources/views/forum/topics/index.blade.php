@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>{{ $course->title }} - Forum</h1>
            <p class="text-muted">Discuss topics related to this course</p>
        </div>
        <div class="col-md-4 text-end">
            @can('create', [App\Models\ForumTopic::class, $course])
                <a href="{{ route('topics.create', ['course' => $course->id]) }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> New Topic
                </a>
            @endcan
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-light">
            <div class="row">
                <div class="col-md-6">Topic</div>
                <div class="col-md-2 text-center">Replies</div>
                <div class="col-md-2 text-center">Created by</div>
                <div class="col-md-2 text-center">Last Activity</div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($topics->count() > 0)
                <ul class="list-group list-group-flush">
                    @foreach($topics as $topic)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex">
                                        <div class="ms-2">
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
                                            <a href="{{ route('topics.show', ['course' => $course, 'topic' => $topic]) }}" class="fw-bold text-decoration-none">
                                                {{ $topic->title }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">
                                    {{ $topic->forum_replies_count ?? $topic->forumReplies->count() }}
                                </div>
                                <div class="col-md-2 text-center">
                                    {{ $topic->user->name }}
                                </div>
                                <div class="col-md-2 text-center">
                                    {{ $topic->updated_at->diffForHumans() }}
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="p-4 text-center">
                    <p>No topics have been created yet.</p>
                    @can('create', [App\Models\ForumTopic::class, $course])
                        <a href="{{ route('topics.create', $course) }}" class="btn btn-primary">
                            Create the first topic
                        </a>
                    @endcan
                </div>
            @endif
        </div>
    </div>

    <div class="mt-4">
        {{ $topics->links() }}
    </div>

    <div class="mt-4">
        <a href="{{ route('courses.show', $course) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Course
        </a>
    </div>
</div>
@endsection
