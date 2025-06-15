@extends('layouts.app')

@section('content')
<style>
    /* Make all text black */
    .container, .card, .form-control, .form-label, .btn {
        color: #000 !important;
    }

    /* Ensure form inputs have visible text when not focused */
    .form-control {
        color: #000 !important;
        background-color: #fff !important;
    }

    /* Ensure placeholder text is visible but lighter */
    .form-control::placeholder {
        color: #666 !important;
        opacity: 1;
    }

    /* Make sure text remains black when focused */
    .form-control:focus {
        color: #000 !important;
        background-color: #fff !important;
    }

    /* Ensure textarea text is visible */
    textarea.form-control {
        color: #000 !important;
        background-color: #fff !important;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="mb-4">
                <a href="{{ route('topics.show', ['course' => $course, 'topic' => $topic]) }}" class="text-decoration-none">
                    <i class="fas fa-arrow-left"></i> Back to Topic
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Edit Topic</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('topics.update', ['course' => $course, 'topic' => $topic]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $topic->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea name="content" id="content" rows="10" class="form-control @error('content') is-invalid @enderror" required>{{ old('content', $topic->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Topic</button>
                            <a href="{{ route('topics.show', ['course' => $course, 'topic' => $topic]) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
