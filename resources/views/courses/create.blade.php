@extends('layouts.app')

@section('content')
<div class="container">
    <h1 style="color: #3b5998; margin-bottom: 20px;">Create a New Course</h1>

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
            <label for="title" style="color: #3b5998; font-weight: 500;">Course Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required
                   style="border-color: #dfe3ee; background-color: #f7f7f7; color: #000000;">
        </div>

        <div class="form-group">
            <label for="description" style="color: #3b5998; font-weight: 500;">Course Description</label>
            <textarea class="form-control" id="description" name="description" rows="5" required
                      style="border-color: #dfe3ee; background-color: #f7f7f7; color: #000000;">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="thumbnail" style="color: #3b5998; font-weight: 500;">Course Thumbnail</label>
            <input type="file" class="form-control-file" id="thumbnail" name="thumbnail" style="color: #4b6ea9;">
            <small class="form-text text-muted" style="color: #8b9dc3 !important;">Recommended size: 1280x720px (16:9 ratio)</small>
        </div>

        <div class="form-group form-check" style="margin-top: 20px; margin-bottom: 25px;">
            <input type="checkbox" class="form-check-input" id="is_published" name="is_published"
                   {{ old('is_published') ? 'checked' : '' }} style="border-color: #3b5998; margin-top: 5px;">
            <label class="form-check-label" for="is_published" style="color: #3b5998; font-weight: 500; padding-left: 5px;">
                Publish Course <span style="color: #8b9dc3; font-weight: normal; font-size: 0.9em;">(Unpublished courses won't be visible to students)</span>
            </label>
        </div>

        <button type="submit" class="btn btn-primary" style="background-color: #3b5998; border-color: #2d4373;">Create Course</button>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary" style="background-color: #8b9dc3; border-color: #8b9dc3;">Cancel</a>
    </form>
</div>
@endsection
