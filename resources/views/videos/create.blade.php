@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Upload New Video for: {{ $course->title }}</h3>
            <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-outline-secondary" id="back-btn">Back to Course</a>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('videos.store', $course) }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id }}">

                <div class="mb-3">
                    <label for="title" class="form-label">Video Title</label>
                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                        name="title" value="{{ old('title') }}" required autofocus
                        style="display: block; width: 100%; padding: 0.375rem 0.75rem; border: 1px solid #ced4da; border-radius: 0.25rem;">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" class="form-control @error('description') is-invalid @enderror"
                        name="description" rows="4" style="display: block; width: 100%; padding: 0.375rem 0.75rem; border: 1px solid #ced4da; border-radius: 0.25rem;">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="video_file" class="form-label">Choose File</label>
                    <input type="file" class="form-control @error('video_file') is-invalid @enderror"
                        id="video_file" name="video_file" required
                        style="display: block; width: 100%; padding: 0.375rem 0.75rem; border: 1px solid #ced4da; border-radius: 0.25rem;">
                    <small class="form-text text-muted">
                        Accepted formats: MP4, AVI, MOV. Maximum size: 100MB.
                    </small>
                </div>

                <div class="mb-3 form-check">
                    <input class="form-check-input" type="checkbox" name="published" id="published" {{ old('published') ? 'checked' : '' }}>
                    <label class="form-check-label" for="published">
                        Publish immediately
                    </label>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-upload"></i> Upload Video
                    </button>
                    <a href="{{ route('courses.show', $course) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Optional: Add client-side validation or preview functionality
    document.getElementById('video_file').addEventListener('change', function(e) {
        // Basic file size validation
        if (this.files[0] && this.files[0].size > 104857600) { // 100MB in bytes
            alert('File is too large! Maximum size is 100MB.');
            this.value = '';
        }
    });
</script>
@endsection
