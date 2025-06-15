@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="mb-4">
                <a href="{{ route('forum.topics.show', ['course' => $course, 'topic' => $topic]) }}" class="text-decoration-none">
                    <i class="fas fa-arrow-left"></i> Back to Topic
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Edit Reply</h5>
                </div>
                <div class="card-body">
                    <!-- Preview Mode -->
                    <div id="preview-mode">
                        <div class="form-group mb-3">
                            <label class="form-label">Current Content</label>
                            <div class="border rounded p-3 bg-light" style="min-height: 200px; white-space: pre-wrap;">{{ $reply->content }}</div>
                        </div>
                        <button type="button" class="btn btn-primary" id="edit-btn">Edit Reply</button>
                        <a href="{{ route('forum.topics.show', ['course' => $course, 'topic' => $topic]) }}" class="btn btn-secondary">Back to Topic</a>
                    </div>

                    <!-- Edit Mode -->
                    <div id="edit-mode" style="display: none;">
                        <form action="{{ route('forum.replies.update', ['course' => $course, 'topic' => $topic, 'reply' => $reply]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label for="content" class="form-label">Content</label>
                                <textarea name="content" id="content" rows="8" class="form-control @error('content') is-invalid @enderror" required>{{ old('content', $reply->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update Reply</button>
                                <button type="button" class="btn btn-secondary" id="cancel-btn">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const previewMode = document.getElementById('preview-mode');
    const editMode = document.getElementById('edit-mode');
    const editBtn = document.getElementById('edit-btn');
    const cancelBtn = document.getElementById('cancel-btn');

    editBtn.addEventListener('click', function() {
        previewMode.style.display = 'none';
        editMode.style.display = 'block';
        document.getElementById('content').focus();
    });

    cancelBtn.addEventListener('click', function() {
        editMode.style.display = 'none';
        previewMode.style.display = 'block';
    });

    // Show edit mode if there are validation errors
    @if($errors->any())
        previewMode.style.display = 'none';
        editMode.style.display = 'block';
    @endif
});
</script>
@endsection
