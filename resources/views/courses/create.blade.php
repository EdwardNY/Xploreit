@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create a New Course</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="title">Course Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        </div>
        
        <div class="form-group">
            <label for="description">Course Description</label>
            <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
        </div>
        
        <div class="form-group">
            <label for="thumbnail">Course Thumbnail</label>
            <input type="file" class="form-control-file" id="thumbnail" name="thumbnail">
            <small class="form-text text-muted">Recommended size: 1280x720px (16:9 ratio)</small>
        </div>
        
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="is_published" name="is_published" {{ old('is_published') ? 'checked' : '' }}>
            <label class="form-check-label" for="is_published">Publish Course</label>
            <small class="form-text text-muted">Unpublished courses won't be visible to students</small>
        </div>
        
        <button type="submit" class="btn btn-primary">Create Course</button>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection