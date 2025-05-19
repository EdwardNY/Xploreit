@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <!-- Top Navigation Bar -->
    <div class="top-navbar">
        <div class="logo-container">
            <a href="{{ route('home') }}" class="logo">
                <svg width="30" height="30" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="50" r="45" stroke="white" stroke-width="4" fill="none"/>
                    <circle cx="50" cy="50" r="20" stroke="white" stroke-width="4" fill="none"/>
                    <line x1="50" y1="10" x2="50" y2="30" stroke="white" stroke-width="4"/>
                    <line x1="50" y1="70" x2="50" y2="90" stroke="white" stroke-width="4"/>
                    <line x1="10" y1="50" x2="30" y2="50" stroke="white" stroke-width="4"/>
                    <line x1="70" y1="50" x2="90" y2="50" stroke="white" stroke-width="4"/>
                </svg>
            </a>
        </div>

        <div class="nav-links">
            <a href="#" class="active">Home</a>
            <a href="#">Learning</a>
            <a href="#">Forum</a>
        </div>

        <div class="user-profile">
            <div class="profile-info">
                <span>Hi, {{ Auth::user()->name ?? 'Guest' }}</span>
                <img src="{{ asset('images/avatar.jpg') }}" alt="Profile" class="profile-avatar">
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2 class="welcome-text">Welcome, Ready to explore ?</h2>

        <div class="search-container">
            <input type="text" placeholder="Search Course" class="search-input">
            <button class="search-button">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M21 21L16.65 16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>

        <!-- Featured Course Banner (Gray rectangle) -->
        <div class="featured-course">
            <!-- Content will be dynamically loaded here -->
        </div>

        <!-- Course Grid -->
        <div class="course-grid">
            <!-- Course cards (4 placeholders as shown in the image) -->
            <div class="course-card">
                <!-- Course content will be dynamically loaded here -->
            </div>
            <div class="course-card">
                <!-- Course content will be dynamically loaded here -->
            </div>
            <div class="course-card">
                <!-- Course content will be dynamically loaded here -->
            </div>
            <div class="course-card">
                <!-- Course content will be dynamically loaded here -->
            </div>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <a href="#" class="bottom-nav-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
        <a href="#" class="bottom-nav-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M21 11.5C21.0034 12.8199 20.6951 14.1219 20.1 15.3C19.3944 16.7118 18.3098 17.8992 16.9674 18.7293C15.6251 19.5594 14.0782 19.9994 12.5 20C11.1801 20.0035 9.87812 19.6951 8.7 19.1L3 21L4.9 15.3C4.30493 14.1219 3.99656 12.8199 4 11.5C4.00061 9.92179 4.44061 8.37488 5.27072 7.03258C6.10083 5.69028 7.28825 4.6056 8.7 3.90003C9.87812 3.30496 11.1801 2.99659 12.5 3.00003H13C15.0843 3.11502 17.053 3.99479 18.5291 5.47089C20.0052 6.94699 20.885 8.91568 21 11V11.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
        <a href="#" class="bottom-nav-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 8V16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M8 12H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
        <a href="#" class="bottom-nav-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
    </div>
</div>

<style>
/* Dashboard container */
.dashboard-container {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    background-color: #f0f2f5;
    position: relative;
}

/* Top Navigation Bar */
.top-navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: #4c5667;
    color: white;
}

.logo-container svg {
    width: 30px;
    height: 30px;
}

.nav-links {
    display: flex;
}

.nav-links a {
    color: white;
    margin: 0 15px;
    text-decoration: none;
    font-size: 14px;
}

.nav-links a.active {
    font-weight: bold;
}

.user-profile {
    display: flex;
    align-items: center;
}

.profile-info {
    display: flex;
    align-items: center;
    font-size: 14px;
}

.profile-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    margin-left: 10px;
}

/* Main Content */
.main-content {
    flex: 1;
    padding: 20px;
}

.welcome-text {
    font-size: 22px;
    margin-bottom: 20px;
    color: #333;
    font-weight: normal;
}

/* Search Bar */
.search-container {
    position: relative;
    margin-bottom: 20px;
}

.search-input {
    width: 100%;
    padding: 10px 40px 10px 15px;
    border: 1px solid #ccc;
    border-radius: 20px;
    font-size: 14px;
}

.search-button {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: #666;
}

/* Featured Course */
.featured-course {
    height: 150px;
    background-color: #e0e0e0;
    border-radius: 8px;
    margin-bottom: 20px;
}

/* Course Grid */
.course-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
}

.course-card {
    aspect-ratio: 1/1;
    background-color: #e0e0e0;
    border-radius: 8px;
}

/* Bottom Navigation */
.bottom-nav {
    display: flex;
    justify-content: space-around;
    padding: 10px 0;
    background-color: white;
    border-top: 1px solid #eee;
}

.bottom-nav-item {
    display: flex;
    justify-content: center;
    align-items: center;
    color: #666;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .course-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .nav-links {
        display: none;
    }

    .profile-info span {
        display: none;
    }
}
</style>
@endsection
