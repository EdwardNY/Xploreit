@extends('layouts.app')

@section('content')
<style>
    /* Custom styles for this page only */
    .topic-form .form-control {
        color: #000 !important; /* Black text color */
    }

    .topic-form .form-control::placeholder {
        color: #6c757d !important; /* Gray placeholder text */
        opacity: 1 !important; /* Ensure placeholder is visible */
    }

    .topic-form .form-control:focus::placeholder {
        color: #adb5bd !important; /* Lighter gray when focused */
    }

    .topic-form label {
        color: #000 !important; /* Black label text */
        font-weight: 500;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="mb-4">
                <a href="{{ route('courses.show', $course) }}" class="text-decoration-none">
                    <i class="fas fa-arrow-left"></i> Back to Course
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Create New Topic</h5>
                </div>
                <div class="card-body topic-form">
                    <form action="{{ route('topics.store', $course) }}" method="POST">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">

                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text"
                                   name="title"
                                   id="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}"
                                   placeholder="Enter topic title..."
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea name="content"
                                      id="content"
                                      rows="10"
                                      class="form-control @error('content') is-invalid @enderror"
                                      placeholder="Enter topic content and description..."
                                      required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create Topic</button>
                            <a href="{{ route('courses.show', $course) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
