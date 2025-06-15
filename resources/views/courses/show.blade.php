@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-8">
            <h1>{{ $course->title }}</h1>
            <p class="text-muted">Instructor: {{ $course->lecturer->name }}</p>
        </div>
        <div class="col-md-4 text-right">
            @if(auth()->check() && auth()->user()->id === $course->lecturer_id)
                <a href="{{ route('courses.edit', $course) }}" class="btn btn-secondary">Edit Course</a>
                <form action="{{ route('courses.destroy', $course) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this course?')">Delete</button>
                </form>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            @if($course->thumbnail)
                <img src="{{ asset('storage/' . $course->thumbnail) }}" class="img-fluid mb-4" alt="{{ $course->title }}">
            @else
                <div class="bg-light text-center py-5 mb-4">No Image</div>
            @endif

            {{-- @if(auth()->check() && auth()->user()->role === 'student')
                <form action="{{ route('enrollments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <button type="submit" class="btn btn-success btn-block mb-4">Enroll in Course</button>
                </form>
            @elseif($isEnrolled)
                <div class="alert alert-info">You are enrolled in this course</div>
            @endif --}}
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Description</h3>
                </div>
                <div class="card-body">
                    {{ $course->description }}
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Course Content</h3>
                    @if(auth()->check() && auth()->user()->id === $course->lecturer_id)
                        <a href="{{ route('videos.create', ['course' => $course->id]) }}" class="btn btn-primary">Add Video</a>
                    @endif
                </div>
                <div class="card-body">
                    @if(count($course->videos) > 0)
                        <div class="list-group">
                            @foreach($course->videos as $video)
                                <a href="{{ route('videos.show', $video) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $video->title }}</h5>
                                        @if($video->is_preview || $isEnrolled || auth()->check() && auth()->user()->id === $course->lecturer_id)
                                            <span class="badge badge-success">Available</span>
                                        @else
                                            <span class="badge badge-secondary">Enroll to view</span>
                                        @endif
                                    </div>
                                    <p class="mb-1">{{ Str::limit($video->description, 100) }}</p>
                                    @if($video->duration)
                                        <small>Duration: {{ gmdate("H:i:s", $video->duration) }}</small>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p>No videos available for this course yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Forum section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Discussion Forum</h3>
                    @if(auth()->check() && (auth()->user()->id === $course->lecturer_id))
                        <a href="{{ route('topics.create', $course) }}" class="btn btn-primary">New Topic</a>
                    @endif
                </div>
                <div class="card-body">
                    @if($course->forumTopics && count($course->forumTopics) > 0)
                        <div class="list-group">
                            @foreach($course->forumTopics as $topic)
                                <a href="{{ route('topics.show', [$course, $topic]) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $topic->title }}</h5>
                                        <small>{{ $topic->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-1">{{ Str::limit($topic->content, 100) }}</p>
                                    <small>By: {{ $topic->user->name }}</small>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p>No discussion topics yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
