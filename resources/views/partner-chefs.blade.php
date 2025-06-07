@extends('layouts.app')

@section('title', 'Partner Chefs - Wholesale | Restaurants & Chefs')

@section('content')
<div class="partner-chefs-page">
    <!-- Hero Section -->
    <section class="partner-hero">
        <div class="hero-background">
            <img src="{{ asset('images/carrusel4.png') }}" alt="Culinary Excellence" class="hero-bg-image">
            <div class="hero-overlay"></div>
        </div>
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-10">
                    <h1 class="hero-title">Wholesale | Restaurants & Chefs</h1>
                    <p class="hero-subtitle">Premium Uruguayan beef for culinary professionals who demand excellence</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="partner-content">
        <div class="container">
            <div class="row">
                <!-- Left Column - Information -->
                <div class="col-lg-6 mb-5">
                    <div class="info-content">
                        <h2 class="section-title">Elevate Your Menu with Premium Beef</h2>
                        <p class="section-description">
                            Join the ranks of renowned chefs and restaurants who trust Meatology for their premium 
                            protein needs. Our grass-fed Uruguayan beef delivers the exceptional quality and consistency 
                            your kitchen demands.
                        </p>
                        
                        <div class="benefits-list">
                            <div class="benefit-item">
                                <div class="benefit-icon">🥩</div>
                                <div class="benefit-text">
                                    <h4>Consistent Quality</h4>
                                    <p>Every cut meets the highest standards with full traceability from farm to plate</p>
                                </div>
                            </div>
                            
                            <div class="benefit-item">
                                <div class="benefit-icon">🚚</div>
                                <div class="benefit-text">
                                    <h4>Reliable Supply</h4>
                                    <p>Dependable delivery schedules to keep your kitchen running smoothly</p>
                                </div>
                            </div>
                            
                            <div class="benefit-item">
                                <div class="benefit-icon">💰</div>
                                <div class="benefit-text">
                                    <h4>Wholesale Pricing</h4>
                                    <p>Competitive rates for volume purchases without compromising on quality</p>
                                </div>
                            </div>
                            
                            <div class="benefit-item">
                                <div class="benefit-icon">👨‍🍳</div>
                                <div class="benefit-text">
                                    <h4>Chef Support</h4>
                                    <p>Dedicated account management and culinary guidance from our team</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column - Form -->
                <div class="col-lg-6">
                    <div class="partner-form-container">
                        <div class="form-header">
                            <h3>Request Wholesale Pricing</h3>
                            <p>If you are a chef or restaurant and would like to create an account for wholesale pricing, please make an inquiry with the following form. We will respond within the next 24 business hours with further information. Thank you!</p>
                        </div>
                        
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        <form action="{{ route('partner.chefs.submit') }}" method="POST" class="partner-form">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label">First name*</label>
                                    <input type="text" 
                                           class="form-control @error('first_name') is-invalid @enderror" 
                                           id="first_name" 
                                           name="first_name" 
                                           value="{{ old('first_name') }}" 
                                           placeholder="John" 
                                           required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label">Last name*</label>
                                    <input type="text" 
                                           class="form-control @error('last_name') is-invalid @enderror" 
                                           id="last_name" 
                                           name="last_name" 
                                           value="{{ old('last_name') }}" 
                                           placeholder="Smith" 
                                           required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email address*</label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           placeholder="john.last@example.com" 
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone number*</label>
                                    <div class="phone-input">
                                        <select class="country-code" name="country_code">
                                            <option value="+1">+1</option>
                                            <option value="+44">+44</option>
                                            <option value="+34">+34</option>
                                            <option value="+33">+33</option>
                                        </select>
                                        <input type="tel" 
                                               class="form-control phone-number @error('phone') is-invalid @enderror" 
                                               id="phone" 
                                               name="phone" 
                                               value="{{ old('phone') }}" 
                                               placeholder="(123) 456-7890" 
                                               required>
                                    </div>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="company_name" class="form-label">Company name*</label>
                                    <input type="text" 
                                           class="form-control @error('company_name') is-invalid @enderror" 
                                           id="company_name" 
                                           name="company_name" 
                                           value="{{ old('company_name') }}" 
                                           placeholder="Wonka Chocolate Factory" 
                                           required>
                                    @error('company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="company_website" class="form-label">Company website</label>
                                    <input type="url" 
                                           class="form-control @error('company_website') is-invalid @enderror" 
                                           id="company_website" 
                                           name="company_website" 
                                           value="{{ old('company_website') }}" 
                                           placeholder="wonkachocolatefactory.com">
                                    @error('company_website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="company_address" class="form-label">Company address*</label>
                                <input type="text" 
                                       class="form-control @error('company_address') is-invalid @enderror" 
                                       id="company_address" 
                                       name="company_address" 
                                       value="{{ old('company_address') }}" 
                                       placeholder="1234 Main St, New York, USA" 
                                       required>
                                @error('company_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="years_in_business" class="form-label">Years in business*</label>
                                <input type="number" 
                                       class="form-control @error('years_in_business') is-invalid @enderror" 
                                       id="years_in_business" 
                                       name="years_in_business" 
                                       value="{{ old('years_in_business') }}" 
                                       placeholder="5" 
                                       min="0" 
                                       required>
                                @error('years_in_business')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <button type="submit" class="submit-btn">
                                Submit Application
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
.partner-chefs-page {
    font-family: 'Inter', sans-serif;
}

.partner-hero {
    position: relative;
    height: 50vh;
    min-height: 400px;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.hero-bg-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(1, 25, 4, 0.8) 0%, rgba(1, 25, 4, 0.7) 100%);
}

.hero-title {
    font-size: 3rem;
    font-weight: 900;
    color: white;
    margin-bottom: 20px;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    position: relative;
    z-index: 2;
}

.hero-subtitle {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.9);
    position: relative;
    z-index: 2;
    font-weight: 300;
}

.partner-content {
    padding: 80px 0;
    background: #f8f9fa;
}

.info-content {
    padding-right: 40px;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #011904;
    margin-bottom: 30px;
    line-height: 1.2;
}

.section-description {
    font-size: 1.1rem;
    line-height: 1.7;
    color: #555;
    margin-bottom: 40px;
}

.benefits-list {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.benefit-item {
    display: flex;
    align-items: flex-start;
    gap: 20px;
}

.benefit-icon {
    font-size: 2.5rem;
    flex-shrink: 0;
}

.benefit-text h4 {
    font-size: 1.3rem;
    font-weight: 700;
    color: #011904;
    margin-bottom: 10px;
}

.benefit-text p {
    color: #666;
    line-height: 1.5;
    margin: 0;
}

.partner-form-container {
    background: linear-gradient(135deg, #011904 0%, #022a07 100%);
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.form-header {
    text-align: center;
    margin-bottom: 40px;
}

.form-header h3 {
    color: white;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 20px;
}

.form-header p {
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.6;
    font-size: 0.95rem;
}

.partner-form .form-label {
    color: #fff;
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 0.9rem;
}

.partner-form .form-control {
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    color: white;
    padding: 12px 16px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.partner-form .form-control::placeholder {
    color: rgba(255, 255, 255, 0.6);
}

.partner-form .form-control:focus {
    background: rgba(255, 255, 255, 0.15);
    border-color: #fff;
    box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
    color: white;
}

.phone-input {
    display: flex;
    gap: 10px;
}

.country-code {
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    color: white;
    padding: 12px;
    width: 80px;
    font-size: 0.95rem;
}

.phone-number {
    flex: 1;
}

.submit-btn {
    width: 100%;
    background: #c41e3a;
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(196, 30, 58, 0.3);
}

.submit-btn:hover {
    background: #e74c3c;
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(196, 30, 58, 0.4);
}

.alert-success {
    background: rgba(40, 167, 69, 0.2);
    border: 2px solid rgba(40, 167, 69, 0.5);
    color: #28a745;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 30px;
}

.is-invalid {
    border-color: #dc3545 !important;
}

.invalid-feedback {
    color: #ff6b6b;
    font-size: 0.85rem;
    margin-top: 5px;
}

/* Responsive */
@media (max-width: 992px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .section-title {
        font-size: 2.2rem;
    }
    
    .info-content {
        padding-right: 0;
        margin-bottom: 40px;
    }
    
    .partner-form-container {
        padding: 30px;
    }
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-subtitle {
        font-size: 1.1rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .partner-content {
        padding: 60px 0;
    }
    
    .benefits-list {
        gap: 25px;
    }
    
    .benefit-item {
        gap: 15px;
    }
    
    .benefit-icon {
        font-size: 2rem;
    }
    
    .partner-form-container {
        padding: 25px;
    }
    
    .form-header h3 {
        font-size: 1.6rem;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 1.8rem;
    }
    
    .section-title {
        font-size: 1.8rem;
    }
    
    .phone-input {
        flex-direction: column;
        gap: 15px;
    }
    
    .country-code {
        width: 100%;
    }
}
</style>
@endsection