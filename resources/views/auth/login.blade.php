@extends('layouts.app')

@section('content')
<div class="login-page">
    <div class="login-card">
        <div class="login-logo">
            <img src="/img/logo.svg" alt="Logo">
            <h4>{{ config('app.name', 'Opus') }}</h4>
            <p>Sign in to your account</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <input id="name" type="text" placeholder="Username"
                    class="form-control @error('name') is-invalid @enderror"
                    name="name" value="{{ old('name') }}" required autocomplete="username" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <input id="password" type="password" placeholder="Password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label text-secondary text-sm" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">
                {{ __('Sign in') }}
            </button>

            @if (Route::has('password.request'))
                <div class="text-center">
                    <a class="text-secondary text-sm text-decoration-none" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
