<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XploreIt - Explore, Learn, and Grow</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #5a6978;
            --primary-dark: #2d3e53;
            --primary-light: #8194ab;
            --light-bg: #f9f9f9;
            --accent: #333;
            --text: #222;
            --text-light: #555;
            --white: #fff;
            --orange: #ff7e28;
            --blue: #3d7cf4;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: var(--light-bg);
        }

        /* Header styles */
        header {
            background-color: var(--primary);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            color: var(--white);
            text-decoration: none;
        }

        .logo svg {
            height: 40px;
            width: 40px;
            margin-right: 10px;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--white);
        }

        .auth-buttons {
            display: flex;
            gap: 10px;
        }

        .auth-buttons button {
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            border: none;
            transition: all 0.3s ease;
        }

        .sign-in {
            background-color: rgba(255, 255, 255, 0.9);
            color: var(--primary-dark);
        }

        .sign-in:hover {
            background-color: rgba(255, 255, 255, 1);
        }

        .register {
            background-color: var(--accent);
            color: white;
        }

        .register:hover {
            background-color: #222;
        }

        /* Hero section */
        .hero {
            background-color: var(--light-bg);
            padding: 4rem 2rem;
            text-align: center;
        }

        .hero h1 {
            font-size: 3rem;
            color: var(--text);
            margin-bottom: 1.5rem;
        }

        .hero p {
            font-size: 1.2rem;
            color: var(--text-light);
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Feature blocks section */
        .feature-blocks {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 2rem;
            padding: 3rem 2rem;
            background-color: var(--white);
        }

        .feature-block {
            background-color: var(--primary);
            border-radius: 10px;
            width: 300px;
            height: 200px;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--white);
            padding: 1.5rem;
        }

        .feature-block i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .feature-block h3 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .feature-block:hover {
            transform: translateY(-5px);
        }

        /* Footer styles */
        footer {
            background-color: var(--primary);
            padding: 1.5rem 2rem;
            margin-top: auto;
        }

        .social-icons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .social-icon {
            color: var(--white);
            font-size: 1.2rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            transform: translateY(-3px);
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .copyright {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .footer-links {
            display: flex;
            gap: 1rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .footer-links a:hover {
            color: var(--white);
        }

        /* Modal styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .auth-modal {
            background-color: var(--primary-dark);
            color: white;
            width: 100%;
            max-width: 320px;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transform: translateY(-20px);
            transition: all 0.3s ease;
            position: relative;
        }

        .modal-overlay.active .auth-modal {
            transform: translateY(0);
        }

        .modal-close {
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .modal-close:hover {
            color: white;
        }

        .auth-modal h2 {
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.3rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .form-control {
            width: 100%;
            padding: 0.6rem;
            border-radius: 4px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .form-control:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.5);
            background-color: rgba(255, 255, 255, 0.2);
        }

        .input-group {
            display: flex;
            position: relative;
        }

        .input-group-text {
            display: flex;
            align-items: center;
            padding: 0.6rem;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-right: none;
            border-radius: 4px 0 0 4px;
            color: rgba(255, 255, 255, 0.7);
        }

        .input-group .form-control {
            border-radius: 0 4px 4px 0;
        }

        .form-check {
            display: flex;
            align-items: center;
            margin: 1rem 0;
        }

        .form-check-input {
            margin-right: 0.5rem;
        }

        .auth-modal .btn {
            width: 100%;
            padding: 0.8rem;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .login-btn {
            background-color: var(--blue);
            color: white;
        }

        .login-btn:hover {
            background-color: #3068d8;
        }

        .signup-btn {
            background-color: var(--orange);
            color: white;
        }

        .signup-btn:hover {
            background-color: #e8711f;
        }

        .forgot-password {
            display: block;
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 1rem;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .forgot-password:hover {
            color: white;
        }

        .alt-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }

        .alt-link a {
            color: white;
            text-decoration: none;
            font-weight: 600;
        }

        .alt-link a:hover {
            text-decoration: underline;
        }

        /* Role selection styles */
        .role-selection {
            display: flex;
            gap: 10px;
            margin-top: 0.5rem;
        }

        .role-option {
            flex: 1;
            position: relative;
        }

        .role-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .role-option label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 0.8rem;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .role-option i {
            font-size: 1.2rem;
            margin-bottom: 0.3rem;
        }

        .role-option input[type="radio"]:checked + label {
            background-color: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.6);
        }

        .invalid-feedback {
            color: #ff7675;
            font-size: 0.85rem;
            margin-top: 0.3rem;
            display: block;
        }

        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .hero h1 {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 767.98px) {
            header {
                padding: 1rem;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .feature-blocks {
                flex-direction: column;
                align-items: center;
            }

            .feature-block {
                width: 100%;
                max-width: 400px;
            }

            .footer-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .footer-links {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header with logo and auth buttons -->
    <header>
        <a href="{{ url('/') }}" class="logo">
            <svg width="40" height="40" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="45" stroke="white" stroke-width="4" fill="none"/>
                <circle cx="50" cy="50" r="20" stroke="white" stroke-width="4" fill="none"/>
                <line x1="50" y1="10" x2="50" y2="30" stroke="white" stroke-width="4"/>
                <line x1="50" y1="70" x2="50" y2="90" stroke="white" stroke-width="4"/>
                <line x1="10" y1="50" x2="30" y2="50" stroke="white" stroke-width="4"/>
                <line x1="70" y1="50" x2="90" y2="50" stroke="white" stroke-width="4"/>
            </svg>
            <span class="logo-text">XploreIt</span>
        </a>

        <div class="auth-buttons">
            <button class="sign-in" id="loginBtn">Sign In</button>
            <button class="register" id="registerBtn">Register</button>
        </div>
    </header>

    <!-- Hero section -->
    <section class="hero">
        <h1>Explore, Learn, and Grow with XploreIt</h1>
        <p>XploreIt takes you into a world of limitless knowledge. Start your learning journey today! 🚀</p>
    </section>

    <!-- Feature blocks section -->
    <section class="feature-blocks">
        <div class="feature-block">
            <i class="fas fa-book"></i>
            <h3>Diverse Courses</h3>
            <p>Explore a wide range of courses across multiple disciplines</p>
        </div>
        <div class="feature-block">
            <i class="fas fa-users"></i>
            <h3>Expert Instructors</h3>
            <p>Learn from experienced professionals in their fields</p>
        </div>
        <div class="feature-block">
            <i class="fas fa-certificate"></i>
            <h3>Earn Certificates</h3>
            <p>Showcase your achievements with verified certificates</p>
        </div>
    </section>

    <!-- Footer with social icons -->
    <footer>
        <div class="container">
            <div class="social-icons">
                <a href="#" class="social-icon">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="#" class="social-icon">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="social-icon">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="social-icon">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="#" class="social-icon">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
            <div class="footer-content">
                <p class="copyright">&copy; {{ date('Y') }} XploreIt. All rights reserved.</p>
                <div class="footer-links">
                    <a href="#">Terms of Service</a>
                    <a href="#">Privacy Policy</a>
                    <a href="#">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Login Modal -->
    <div class="modal-overlay" id="loginModal">
        <div class="auth-modal">
            <button class="modal-close" id="closeLoginModal">
                <i class="fas fa-times"></i>
            </button>
            <h2>LOGIN:</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <button type="submit" class="btn login-btn">
                    {{ __('LOGIN') }}
                </button>

                @if (Route::has('password.request'))
                    <a class="forgot-password" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif

                <div class="alt-link">
                    Don't have an account? <a href="#" id="switchToRegister">Register</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal-overlay" id="registerModal">
        <div class="auth-modal">
            <button class="modal-close" id="closeRegisterModal">
                <i class="fas fa-times"></i>
            </button>
            <h2>Create New Account:</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input id="register-email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name">
                    </div>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input id="register-password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                    </div>
                </div>

                <div class="form-group">
                    <label>{{ __('Register as') }}</label>
                    <div class="role-selection">
                        <div class="role-option">
                            <input type="radio" id="student" name="role" value="student" {{ old('role') == 'student' ? 'checked' : '' }} required>
                            <label for="student">
                                <i class="fas fa-user-graduate"></i>
                                Student
                            </label>
                        </div>
                        <div class="role-option">
                            <input type="radio" id="lecturer" name="role" value="lecturer" {{ old('role') == 'lecturer' ? 'checked' : '' }}>
                            <label for="lecturer">
                                <i class="fas fa-chalkboard-teacher"></i>
                                Lecturer
                            </label>
                        </div>
                    </div>
                    @error('role')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn signup-btn">
                    {{ __('SIGN UP') }}
                </button>

                <div class="alt-link">
                    Already have an account? <a href="#" id="switchToLogin">Login</a>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for mobile menu toggle and modals -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Login modal
            const loginBtn = document.getElementById('loginBtn');
            const loginModal = document.getElementById('loginModal');
            const closeLoginModal = document.getElementById('closeLoginModal');

            loginBtn.addEventListener('click', function() {
                loginModal.classList.add('active');
            });

            closeLoginModal.addEventListener('click', function() {
                loginModal.classList.remove('active');
            });

            // Register modal
            const registerBtn = document.getElementById('registerBtn');
            const registerModal = document.getElementById('registerModal');
            const closeRegisterModal = document.getElementById('closeRegisterModal');

            registerBtn.addEventListener('click', function() {
                registerModal.classList.add('active');
            });

            closeRegisterModal.addEventListener('click', function() {
                registerModal.classList.remove('active');
            });

            // Switch between modals
            const switchToRegister = document.getElementById('switchToRegister');
            const switchToLogin = document.getElementById('switchToLogin');

            switchToRegister.addEventListener('click', function(e) {
                e.preventDefault();
                loginModal.classList.remove('active');
                registerModal.classList.add('active');
            });

            switchToLogin.addEventListener('click', function(e) {
                e.preventDefault();
                registerModal.classList.remove('active');
                loginModal.classList.add('active');
            });

            // Close modals when clicking outside
            loginModal.addEventListener('click', function(e) {
                if (e.target === loginModal) {
                    loginModal.classList.remove('active');
                }
            });

            registerModal.addEventListener('click', function(e) {
                if (e.target === registerModal) {
                    registerModal.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>
