@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>🔐 Reset Password</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4 text-muted">
                        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success mb-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">{{ __('Email') }}</label>
                            <input id="email"
                                   type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="your.email@example.com"
                                   required
                                   autofocus>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                📧 {{ __('Email Password Reset Link') }}
                            </button>

                            <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                                ← {{ __('Back to Login') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-3 text-center">
                <small class="text-muted">
                    🔒 Secure password reset <br>
                    💚 Meatology - Premium meat products
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
