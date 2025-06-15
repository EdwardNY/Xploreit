{{-- layouts/navigation.blade.php - Partial for navigation header --}}
<nav class="navbar">
    <div class="container">
        <a href="{{ route('dashboard') }}" class="logo">
            <svg width="30" height="30" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="45" stroke="currentColor" stroke-width="4" fill="none"/>
                <circle cx="50" cy="50" r="20" stroke="currentColor" stroke-width="4" fill="none"/>
                <line x1="50" y1="10" x2="50" y2="30" stroke="currentColor" stroke-width="4"/>
                <line x1="50" y1="70" x2="50" y2="90" stroke="currentColor" stroke-width="4"/>
                <line x1="10" y1="50" x2="30" y2="50" stroke="currentColor" stroke-width="4"/>
                <line x1="70" y1="50" x2="90" y2="50" stroke="currentColor" stroke-width="4"/>
            </svg>
            <span class="logo-text">XploreIt</span>
        </a>

        <div class="navbar-content">
            <!-- Main navigation links -->
            <div class="navigation-links">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('courses') }}" class="nav-link {{ request()->routeIs('courses*') ? 'active' : '' }}">Courses</a>
                <a href="{{ route('resources') }}" class="nav-link {{ request()->routeIs('resources*') ? 'active' : '' }}">Resources</a>
                @if(Auth::user()->role == 'researcher' || Auth::user()->role == 'lecturer' || Auth::user()->role == 'admin')
                <a href="{{ route('research') }}" class="nav-link {{ request()->routeIs('research*') ? 'active' : '' }}">Research</a>
                @endif
            </div>

            <!-- User profile dropdown -->
            <div class="user-profile">
                <div class="user-info">
                    <span class="username">{{ Auth::user()->name }}</span>
                    <span class="role-badge
                        @if(Auth::user()->role == 'admin') role-admin
                        @elseif(Auth::user()->role == 'lecturer') role-lecturer
                        @elseif(Auth::user()->role == 'researcher') role-researcher
                        @else role-student @endif">
                        {{ ucfirst(Auth::user()->role) }}
                    </span>
                </div>
                <div class="dropdown">
                    <button class="dropdown-toggle">
                        <img src="{{ Auth::user()->profile_photo_url ?? asset('images/default-avatar.png') }}"
                             alt="{{ Auth::user()->name }}" class="avatar-img">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="dropdown-menu">
                        <div class="dropdown-header">{{ Auth::user()->email }}</div>
                        <a href="{{ route('profile.show') }}" class="dropdown-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            My Profile
                        </a>
                        <a href="{{ route('notifications') }}" class="dropdown-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                            Notifications
                        </a>
                        @if(Auth::user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                            Admin Panel
                        </a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="dropdown-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
/* Additional CSS for navigation links */
.navigation-links {
    display: flex;
    gap: 1.5rem;
}

.nav-link {
    color: #4a5568;
    text-decoration: none;
    font-weight: 500;
    padding: 0.5rem 0;
    position: relative;
}

.nav-link:hover {
    color: #2d3748;
}

.nav-link.active {
    color: #3182ce;
}

.nav-link.active:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 2px;
    background-color: #3182ce;
}

/* Responsive navigation */
@media (max-width: 768px) {
    .navbar-content {
        flex-direction: column;
        gap: 1rem;
        width: 100%;
    }

    .navigation-links {
        width: 100%;
        justify-content: space-between;
    }

    .user-profile {
        width: 100%;
        justify-content: flex-end;
    }
}

@media (max-width: 576px) {
    .navigation-links {
        flex-wrap: wrap;
        gap: 0.5rem 1rem;
    }

    .nav-link {
        padding: 0.5rem;
    }
}
</style>
