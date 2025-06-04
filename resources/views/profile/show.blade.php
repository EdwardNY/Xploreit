@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Profile Sidebar -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <!-- Profile Picture -->
                    @if($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}"
                             class="rounded-circle mb-3"
                             width="120" height="120"
                             style="object-fit: cover;"
                             alt="Profile Picture">
                    @else
                        <div class="bg-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                             style="width: 120px; height: 120px;">
                            <span class="text-white h2 mb-0">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                    @endif

                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-1">{{ $user->email }}</p>

                    <!-- Role Badge -->
                    <span class="badge bg-{{ $user->isLecturer() ? 'primary' : 'info' }} mb-3">
                        {{ $user->isLecturer() ? 'Lecturer' : 'Student' }}
                    </span>

                    <!-- Bio -->
                    @if($user->bio)
                        <p class="text-muted small mt-3">{{ $user->bio }}</p>
                    @endif

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
                        @if($user->isLecturer())
                            <a href="{{ route('courses.create') }}" class="btn btn-success">
                                <i class="fas fa-plus"></i> Create Course
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            @if($user->isLecturer() && isset($stats))
                <!-- Statistics Card -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-chart-bar"></i> Statistics</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <h4 class="text-primary mb-0">{{ $stats['total_courses'] }}</h4>
                                <small class="text-muted">Total Courses</small>
                            </div>
                            <div class="col-6 mb-3">
                                <h4 class="text-success mb-0">{{ $stats['published_courses'] }}</h4>
                                <small class="text-muted">Published</small>
                            </div>
                            <div class="col-6 mb-3">
                                <h4 class="text-warning mb-0">{{ $stats['draft_courses'] }}</h4>
                                <small class="text-muted">Drafts</small>
                            </div>
                            <div class="col-6 mb-3">
                                <h4 class="text-info mb-0">{{ $stats['total_students'] }}</h4>
                                <small class="text-muted">Total Students</small>
                            </div>
                        </div>

                        @if($stats['total_videos'] > 0 || $stats['total_discussions'] > 0)
                            <hr>
                            <div class="row text-center">
                                <div class="col-6">
                                    <strong class="text-secondary">{{ $stats['total_videos'] }}</strong>
                                    <br><small class="text-muted">Videos</small>
                                </div>
                                <div class="col-6">
                                    <strong class="text-secondary">{{ $stats['total_discussions'] }}</strong>
                                    <br><small class="text-muted">Discussions</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Main Content -->
        <div class="col-md-8">
            @if($user->isLecturer())
                <!-- Courses Section -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-graduation-cap"></i> My Courses</h5>
                        <a href="{{ route('courses.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> New Course
                        </a>
                    </div>
                    <div class="card-body">
                        @if($courses->count() > 0)
                            <div class="row">
                                @foreach($courses as $course)
                                    <div class="col-lg-6 mb-4">
                                        <div class="card h-100 shadow-sm border-0">
                                            <!-- Course Thumbnail -->
                                            @if($course->thumbnail)
                                                <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                                     class="card-img-top"
                                                     style="height: 160px; object-fit: cover;"
                                                     alt="{{ $course->title }}">
                                            @else
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                                     style="height: 160px;">
                                                    <i class="fas fa-book text-muted fa-3x"></i>
                                                </div>
                                            @endif

                                            <div class="card-body d-flex flex-column">
                                                <!-- Course Title -->
                                                <h6 class="card-title fw-bold">{{ $course->title }}</h6>

                                                <!-- Course Description -->
                                                <p class="card-text text-muted small flex-grow-1">
                                                    {{ Str::limit($course->description, 80) }}
                                                </p>

                                                <!-- Course Stats -->
                                                <div class="d-flex justify-content-between text-muted small mb-2">
                                                    <span><i class="fas fa-users"></i> {{ $course->enrollments_count ?? 0 }} students</span>
                                                    <span><i class="fas fa-video"></i> {{ $course->videos_count ?? 0 }} videos</span>
                                                </div>

                                                <!-- Status and Date -->
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <span class="badge bg-{{ $course->is_published ? 'success' : 'warning' }}">
                                                        {{ $course->is_published ? 'Published' : 'Draft' }}
                                                    </span>
                                                    <small class="text-muted">
                                                        {{ $course->created_at->format('M d, Y') }}
                                                    </small>
                                                </div>

                                                <!-- Action Buttons -->
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('courses.show', $course) }}"
                                                       class="btn btn-outline-primary">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                    <a href="{{ route('courses.edit', $course) }}"
                                                       class="btn btn-outline-secondary">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- View All Courses Link -->
                            @if($courses->count() >= 6)
                                <div class="text-center mt-3">
                                    <a href="{{ route('courses.index') }}" class="btn btn-outline-primary">
                                        View All My Courses
                                    </a>
                                </div>
                            @endif
                        @else
                            <!-- Empty State -->
                            <div class="text-center py-5">
                                <i class="fas fa-graduation-cap text-muted mb-3" style="font-size: 3rem;"></i>
                                <h6 class="text-muted mb-3">No courses created yet</h6>
                                <p class="text-muted mb-4">Start sharing your knowledge by creating your first course!</p>
                                <a href="{{ route('courses.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Create Your First Course
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <!-- Student Enrollments -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-book-reader"></i> My Enrolled Courses</h5>
                    </div>
                    <div class="card-body">
                        @if($enrollments->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($enrollments as $enrollment)
                                    <div class="list-group-item border-0 px-0 py-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1 me-3">
                                                <h6 class="mb-1 fw-bold">{{ $enrollment->course->title }}</h6>
                                                <p class="mb-2 text-muted small">
                                                    {{ Str::limit($enrollment->course->description, 120) }}
                                                </p>

                                                <!-- Course Info -->
                                                <div class="d-flex gap-3 text-muted small">
                                                    <span><i class="fas fa-video"></i> {{ $enrollment->course->videos_count ?? 0 }} videos</span>
                                                    <span><i class="fas fa-users"></i> {{ $enrollment->course->enrollments_count ?? 0 }} students</span>
                                                    <span><i class="fas fa-calendar"></i> Enrolled {{ $enrollment->created_at->format('M d, Y') }}</span>
                                                </div>
                                            </div>

                                            <div class="flex-shrink-0">
                                                <a href="{{ route('courses.show', $enrollment->course) }}"
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-play"></i> Continue Learning
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <!-- Empty State for Students -->
                            <div class="text-center py-5">
                                <i class="fas fa-book-reader text-muted mb-3" style="font-size: 3rem;"></i>
                                <h6 class="text-muted mb-3">No enrolled courses</h6>
                                <p class="text-muted mb-4">Discover amazing courses and start your learning journey!</p>
                                <a href="{{ route('courses.index') }}" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Browse Courses
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-2px);
}

.badge {
    font-size: 0.75em;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>
@endpush
