@extends('layouts.app')

@section('content')
<div class="container">
    <div class="login-card">
        <div class="login-card-header">
            <h2>{{ __('Login') }}</h2>
        </div>

        <div class="login-card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group remember-checkbox">
                    <div class="custom-checkbox">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>

                <div class="form-group login-buttons">
                    <button type="submit" class="btn-login">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn-forgot" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>

                <div class="register-link">
                    <p>Don't have an account? <a href="{{ route('register') }}">Register</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Reset and base styles to match welcome.blade.php */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        min-height: 100vh;
        background-color: hsl(210, 46%, 11%);
    }

    .container {
        max-width: 500px;
        margin: 0 auto;
        padding: 4rem 1rem;
    }

    /* Login card styling to match welcome.blade.php theme */
    .login-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .login-card-header {
        background-color: #5a6978;
        color: white;
        padding: 1.5rem;
        text-align: center;
    }

    .login-card-header h2 {
        font-size: 1.5rem;
        font-weight: bold;
        margin: 0;
    }

    .login-card-body {
        padding: 2rem 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #222;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: 4px;
        border: 1px solid #ddd;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        border-color: #5a6978;
        outline: none;
        box-shadow: 0 0 0 3px rgba(90, 105, 120, 0.2);
    }

    .is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .remember-checkbox {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .custom-checkbox {
        display: flex;
        align-items: center;
    }

    .form-check-input {
        margin-right: 0.5rem;
        width: 1rem;
        height: 1rem;
    }

    .login-buttons {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .btn-login {
        background-color: #5a6978;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 4px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: transform 0.3s ease, background-color 0.3s ease;
    }

    .btn-login:hover {
        background-color: #47546a;
        transform: translateY(-2px);
    }

    .btn-forgot {
        color: #5a6978;
        text-decoration: none;
        font-size: 0.95rem;
        transition: color 0.3s ease;
    }

    .btn-forgot:hover {
        color: #47546a;
        text-decoration: underline;
    }

    .register-link {
        text-align: center;
        padding-top: 1rem;
        border-top: 1px solid #eee;
    }

    .register-link a {
        color: #5a6978;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .register-link a:hover {
        color: #47546a;
        text-decoration: underline;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .login-buttons {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-login {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .container {
            padding: 2rem 1rem;
        }
    }
</style>
@endsection
