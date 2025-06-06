@extends('layouts.app')

@section('title', 'Login - Meatology')

@section('content')
<div class="login-page">
    <div class="container">
        <div class="row min-vh-100 align-items-center justify-content-center">
            <div class="col-lg-10">
                <div class="login-container">
                    <div class="row g-0">
                        <!-- Left Column - Image/Branding -->
                        <div class="col-lg-6 login-image-section">
                            <div class="login-brand">
                                <img src="{{ asset('images/logo.png') }}" alt="Meatology Logo" class="brand-logo">
                                <h2 class="brand-title">Welcome Back</h2>
                                <p class="brand-subtitle">
                                    Premium grass-fed beef from Uruguay. Experience the finest quality meat, ethically sourced and delivered with care.
                                </p>
                                <div class="brand-features">
                                    <div class="feature-item">
                                        <i class="fas fa-check-circle"></i>
                                        <span>100% Grass-Fed</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Certified Humane®</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Sustainable Farming</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Column - Form -->
                        <div class="col-lg-6 login-form-section">
                            <div class="login-form-container">
                                <div class="form-header">
                                    <h3>Sign In</h3>
                                    <p>Access your account to manage orders and preferences</p>
                                </div>

                                <!-- Session Status -->
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <!-- Success Message -->
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}" class="login-form">
                                    @csrf

                                    <!-- Email Address -->
                                    <div class="form-group">
                                        <label for="email" class="form-label">
                                            <i class="fas fa-envelope me-2"></i>Email Address
                                        </label>
                                        <input id="email" 
                                               type="email" 
                                               name="email" 
                                               value="{{ old('email') }}" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               placeholder="Enter your email address"
                                               required 
                                               autofocus 
                                               autocomplete="username">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="form-group">
                                        <label for="password" class="form-label">
                                            <i class="fas fa-lock me-2"></i>Password
                                        </label>
                                        <div class="password-input">
                                            <input id="password" 
                                                   type="password" 
                                                   name="password" 
                                                   class="form-control @error('password') is-invalid @enderror" 
                                                   placeholder="Enter your password"
                                                   required 
                                                   autocomplete="current-password">
                                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                                <i class="fas fa-eye" id="toggleIcon"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Remember Me & Forgot Password -->
                                    <div class="form-options">
                                        <div class="remember-me">
                                            <input type="checkbox" id="remember_me" name="remember" class="form-check-input">
                                            <label for="remember_me" class="form-check-label">
                                                Remember me
                                            </label>
                                        </div>
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="forgot-password">
                                                Forgot password?
                                            </a>
                                        @endif
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" class="login-btn">
                                        <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                    </button>

                                    <!-- Register Link -->
                                    <div class="register-link">
                                        <p>Don't have an account? 
                                            <a href="{{ route('register') }}">Create one here</a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.login-page {
    background: linear-gradient(135deg, #f8f9fa 0%, rgba(1, 25, 4, 0.05) 100%);
    min-height: 100vh;
    padding: 40px 0;
    font-family: 'Inter', sans-serif;
}

.login-container {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    max-width: 1000px;
    margin: 0 auto;
}

.login-image-section {
    background: linear-gradient(135deg, #011904 0%, #022a07 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 40px;
    position: relative;
    overflow: hidden;
}

.login-image-section::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: url('{{ asset("images/carrusel1.png") }}') center/cover;
    opacity: 0.1;
    transform: rotate(-15deg);
}

.login-brand {
    text-align: center;
    position: relative;
    z-index: 2;
}

.brand-logo {
    height: 60px;
    margin-bottom: 30px;
    filter: brightness(0) invert(1);
}

.brand-title {
    font-size: 2.5rem;
    font-weight: 900;
    margin-bottom: 20px;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.brand-subtitle {
    font-size: 1.1rem;
    line-height: 1.6;
    opacity: 0.9;
    margin-bottom: 40px;
}

.brand-features {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 1rem;
}

.feature-item i {
    color: #c41e3a;
    font-size: 1.2rem;
}

.login-form-section {
    background: white;
    display: flex;
    align-items: center;
}

.login-form-container {
    padding: 60px 50px;
    width: 100%;
}

.form-header {
    text-align: center;
    margin-bottom: 40px;
}

.form-header h3 {
    font-size: 2.2rem;
    font-weight: 800;
    color: #011904;
    margin-bottom: 15px;
}

.form-header p {
    color: #666;
    font-size: 1rem;
    line-height: 1.5;
}

.login-form .form-group {
    margin-bottom: 25px;
}

.login-form .form-label {
    color: #011904;
    font-weight: 600;
    margin-bottom: 10px;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
}

.login-form .form-control {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 15px 20px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.login-form .form-control:focus {
    border-color: #011904;
    box-shadow: 0 0 0 0.2rem rgba(1, 25, 4, 0.25);
    background: white;
}

.password-input {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #666;
    cursor: pointer;
    transition: color 0.3s ease;
}

.password-toggle:hover {
    color: #011904;
}

.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 15px;
}

.remember-me {
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-check-input {
    width: 18px;
    height: 18px;
    border: 2px solid #011904;
    border-radius: 4px;
}

.form-check-input:checked {
    background-color: #011904;
    border-color: #011904;
}

.form-check-label {
    color: #666;
    font-size: 0.95rem;
    cursor: pointer;
}

.forgot-password {
    color: #c41e3a;
    text-decoration: none;
    font-size: 0.95rem;
    font-weight: 500;
    transition: color 0.3s ease;
}

.forgot-password:hover {
    color: #e74c3c;
    text-decoration: underline;
}

.login-btn {
    width: 100%;
    background: linear-gradient(135deg, #011904 0%, #022a07 100%);
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 1.1rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(1, 25, 4, 0.3);
    margin-bottom: 25px;
}

.login-btn:hover {
    background: linear-gradient(135deg, #022a07 0%, #033309 100%);
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(1, 25, 4, 0.4);
}

.register-link {
    text-align: center;
    margin-top: 20px;
}

.register-link p {
    color: #666;
    margin: 0;
}

.register-link a {
    color: #c41e3a;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.register-link a:hover {
    color: #e74c3c;
    text-decoration: underline;
}

.alert-success {
    background: rgba(40, 167, 69, 0.1);
    border: 2px solid rgba(40, 167, 69, 0.3);
    color: #28a745;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 25px;
}

.is-invalid {
    border-color: #dc3545 !important;
}

.invalid-feedback {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 5px;
}

/* Responsive */
@media (max-width: 992px) {
    .login-image-section {
        padding: 40px 30px;
    }
    
    .brand-title {
        font-size: 2rem;
    }
    
    .brand-features {
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
    }
    
    .feature-item {
        font-size: 0.9rem;
    }
    
    .login-form-container {
        padding: 40px 30px;
    }
}

@media (max-width: 768px) {
    .login-page {
        padding: 20px 0;
    }
    
    .login-container {
        margin: 20px;
        border-radius: 15px;
    }
    
    .login-image-section {
        padding: 30px 20px;
    }
    
    .brand-title {
        font-size: 1.8rem;
    }
    
    .brand-subtitle {
        font-size: 1rem;
    }
    
    .login-form-container {
        padding: 30px 25px;
    }
    
    .form-header h3 {
        font-size: 1.8rem;
    }
    
    .form-options {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}

@media (max-width: 576px) {
    .brand-features {
        flex-direction: column;
        align-items: center;
    }
    
    .login-form-container {
        padding: 25px 20px;
    }
}
</style>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
</script>
@endsection