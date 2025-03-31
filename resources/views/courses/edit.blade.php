@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Course</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('courses.update', $course) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="title">Course Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $course->title) }}" required>
        </div>
        
        <div class="form-group">
            <label for="description">Course Description</label>
            <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description', $course->description) }}</textarea>
        </div>
        
        <div class="form-group">
            <label for="thumbnail">Course Thumbnail</label>
            @if($course->thumbnail)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $course->thumbnail) }}" style="max-height: 200px;" class="img-thumbnail">
                </div>
            @endif
            <input type="file" class="form-control-file" id="thumbnail" name="thumbnail">
            <small class="form-text text-muted">Leave empty to keep current thumbnail</small>
        </div>
        
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="is_published" name="is_published" {{ old('is_published', $course->is_published) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_published">Publish Course</label>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Course</button>
        <a href="{{ route('courses.show', $course) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection