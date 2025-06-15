@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 900px; margin: 0 auto; padding: 20px;">
    <div class="card border-0 shadow-sm" style="background: #f8f9fa; border-radius: 12px;">
        <div class="card-body" style="padding: 40px;">
            <h1 class="mb-4" style="color: #4a6fa5; font-weight: 600; font-size: 2rem;">Edit Course</h1>

            @if ($errors->any())
                <div class="alert alert-danger" style="border-radius: 8px; border: none; background-color: #f8d7da; color: #721c24;">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group mb-4">
                    <label for="title" class="form-label mb-2" style="color: #4a6fa5; font-weight: 500; font-size: 16px;">Course Title</label>
                    <input type="text"
                           class="form-control custom-input"
                           id="title"
                           name="title"
                           value="{{ old('title', $course->title) }}"
                           required
                           style="border: 2px solid #e9ecef; border-radius: 8px; padding: 12px 16px; font-size: 16px; background-color: #fff; color: #212529 !important; transition: all 0.3s ease;">
                </div>

                <div class="form-group mb-4">
                    <label for="description" class="form-label mb-2" style="color: #4a6fa5; font-weight: 500; font-size: 16px;">Course Description</label>
                    <textarea class="form-control custom-textarea"
                              id="description"
                              name="description"
                              rows="8"
                              required
                              style="border: 2px solid #e9ecef; border-radius: 8px; padding: 16px; font-size: 16px; background-color: #fff; color: #212529 !important; min-height: 150px; resize: vertical; transition: all 0.3s ease; font-family: inherit; line-height: 1.5;">{{ old('description', $course->description) }}</textarea>
                </div>

                <div class="form-group mb-4">
                    <label for="thumbnail" class="form-label mb-2" style="color: #4a6fa5; font-weight: 500; font-size: 16px;">Course Thumbnail</label>
                    @if($course->thumbnail)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                 style="max-height: 200px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);"
                                 class="img-thumbnail border-0"
                                 alt="Current thumbnail">
                        </div>
                    @endif
                    <div class="custom-file-upload" style="position: relative;">
                        <input type="file"
                               class="form-control custom-file-input"
                               id="thumbnail"
                               name="thumbnail"
                               accept="image/*"
                               style="border: 2px solid #e9ecef; border-radius: 8px; padding: 12px 16px; font-size: 16px; background-color: #fff; cursor: pointer; transition: all 0.3s ease;">
                    </div>
                    <small class="form-text" style="color: #6c757d; font-size: 14px; margin-top: 8px; display: block;">
                        Recommended size: 1280x720px (16:9 ratio). Leave empty to keep current thumbnail.
                    </small>
                </div>

                <div class="form-group mb-5">
                    <div class="form-check d-flex align-items-center" style="padding-left: 0;">
                        <!-- Hidden input to ensure a value is always sent -->
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox"
                               class="form-check-input me-3"
                               id="is_published"
                               name="is_published"
                               value="1"
                               {{ old('is_published', $course->is_published) ? 'checked' : '' }}
                               style="width: 20px; height: 20px; border: 2px solid #4a6fa5; border-radius: 4px; margin-top: 0;">
                        <div>
                            <label class="form-check-label" for="is_published" style="color: #4a6fa5; font-weight: 500; font-size: 16px; cursor: pointer;">
                                Publish Course
                            </label>
                            <small class="form-text d-block" style="color: #6c757d; font-size: 14px; margin-top: 4px;">
                                Unpublished courses won't be visible to students
                            </small>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <button type="submit"
                            class="btn btn-primary custom-btn-primary"
                            style="background-color: #4a6fa5; border: none; border-radius: 8px; padding: 12px 24px; font-weight: 500; font-size: 16px; transition: all 0.3s ease;">
                        Update Course
                    </button>
                    <a href="{{ route('courses.show', $course) }}"
                       class="btn btn-secondary custom-btn-secondary"
                       style="background-color: #6c757d; border: none; border-radius: 8px; padding: 12px 24px; font-weight: 500; font-size: 16px; color: white; text-decoration: none; transition: all 0.3s ease;">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Custom styles to match the design */
.custom-input,
.custom-textarea {
    color: #212529 !important;
    background-color: #fff !important;
}

.custom-input:focus,
.custom-textarea:focus,
.custom-file-input:focus {
    border-color: #4a6fa5 !important;
    box-shadow: 0 0 0 0.2rem rgba(74, 111, 165, 0.25) !important;
    outline: none;
    color: #212529 !important;
}

.custom-input:hover,
.custom-textarea:hover,
.custom-file-input:hover {
    border-color: #4a6fa5;
}

.custom-btn-primary:hover {
    background-color: #3a5a95 !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(74, 111, 165, 0.3);
}

.custom-btn-secondary:hover {
    background-color: #5a6268 !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
}

.form-check-input:checked {
    background-color: #4a6fa5;
    border-color: #4a6fa5;
}

.form-check-input:focus {
    border-color: #4a6fa5;
    box-shadow: 0 0 0 0.2rem rgba(74, 111, 165, 0.25);
}

/* Ensure textarea content is always visible */
.custom-textarea,
.custom-input {
    color: #212529 !important;
    background-color: #fff !important;
}

.custom-input::placeholder,
.custom-textarea::placeholder {
    color: #6c757d !important;
    opacity: 1;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container {
        padding: 10px !important;
    }

    .card-body {
        padding: 20px !important;
    }

    .d-flex.gap-3 {
        flex-direction: column;
        gap: 12px !important;
    }

    .custom-btn-primary,
    .custom-btn-secondary {
        width: 100%;
        text-align: center;
    }
}
</style>

<script>
// Ensure textarea content loads properly
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('description');
    const titleInput = document.getElementById('title');

    // Fix textarea
    if (textarea) {
        const value = textarea.value;
        textarea.value = '';
        textarea.value = value;
        textarea.style.color = '#212529';
        textarea.style.backgroundColor = '#fff';
    }

    // Fix title input
    if (titleInput) {
        const value = titleInput.value;
        titleInput.value = '';
        titleInput.value = value;
        titleInput.style.color = '#212529';
        titleInput.style.backgroundColor = '#fff';
    }

    // Add event listeners to maintain text visibility
    [textarea, titleInput].forEach(element => {
        if (element) {
            element.addEventListener('blur', function() {
                this.style.color = '#212529';
                this.style.backgroundColor = '#fff';
            });

            element.addEventListener('input', function() {
                this.style.color = '#212529';
            });
        }
    });
});
</script>
@endsection
