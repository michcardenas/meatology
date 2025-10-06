@extends('layouts.app')

@section('title', 'Wholesale | Restaurants & Chefs - Meatology')

@section('content')

<style>
    .wholesale-page {
        background: linear-gradient(135deg, #ffffff 0%, #e8f5e9 100%);
        min-height: 100vh;
        padding: 80px 0;
        font-family: 'Inter', sans-serif;
    }

    .container-form {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .form-title {
        color: #011904;
        font-size: 2.8rem;
        font-weight: 800;
        text-align: center;
        margin-bottom: 20px;
        letter-spacing: -0.5px;
    }

    .form-subtitle {
        color: #2d5016;
        font-size: 1.1rem;
        text-align: center;
        margin-bottom: 50px;
        font-weight: 400;
    }

    .form-container {
        background: #ffffff;
        border: 1px solid #e0d9c0;
        border-radius: 20px;
        padding: 50px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
    }

    .form-description {
        color: #2c3e50;
        font-size: 1.05rem;
        line-height: 1.8;
        margin-bottom: 40px;
        text-align: left;
        padding: 25px;
        background: rgba(232, 245, 233, 0.4);
        border-left: 4px solid #2d5016;
        border-radius: 8px;
    }

    .form-row {
        display: flex;
        gap: 25px;
        margin-bottom: 30px;
    }

    .form-group {
        flex: 1;
    }

    .form-group.full-width {
        width: 100%;
    }

    label {
        display: block;
        color: #011904;
        font-size: 0.95rem;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .required {
        color: #dc3545;
        margin-left: 3px;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="url"],
    input[type="number"],
    textarea,
    select {
        width: 100%;
        padding: 14px 18px;
        background-color: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        font-size: 1rem;
        color: #2c3e50;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
    }

    input::placeholder,
    textarea::placeholder {
        color: #adb5bd;
    }

    input:focus,
    textarea:focus,
    select:focus {
        outline: none;
        border-color: #2d5016;
        box-shadow: 0 0 0 4px rgba(45, 80, 22, 0.1);
        background-color: #ffffff;
    }

    .phone-container {
        display: flex;
        gap: 12px;
    }

    .country-code {
        width: 90px;
        flex-shrink: 0;
    }

    .phone-number {
        flex: 1;
    }

    textarea {
        height: 120px;
        resize: vertical;
        min-height: 80px;
        max-height: 300px;
    }

    .submit-btn {
        background: linear-gradient(135deg, #2d5016 0%, #011904 100%);
        color: white;
        padding: 16px 50px;
        border: none;
        border-radius: 10px;
        font-size: 1.1rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 30px;
        box-shadow: 0 8px 25px rgba(45, 80, 22, 0.3);
        width: 100%;
    }

    .submit-btn:hover {
        background: linear-gradient(135deg, #011904 0%, #000000 100%);
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(1, 25, 4, 0.4);
    }

    .submit-btn:active {
        transform: translateY(-1px);
    }

    /* Mensajes de error */
    .error-message {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .error-message::before {
        content: "⚠";
        font-size: 1rem;
    }

    .form-group.has-error input,
    .form-group.has-error select,
    .form-group.has-error textarea {
        border-color: #dc3545;
        background-color: #fff5f5;
    }

    /* Mensajes de éxito */
    .success-message {
        background: rgba(40, 167, 69, 0.1);
        border: 2px solid rgba(40, 167, 69, 0.3);
        color: #28a745;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 1rem;
    }

    .success-message::before {
        content: "✓";
        font-size: 1.5rem;
        font-weight: bold;
    }

    /* Iconos en los labels */
    .label-icon {
        margin-right: 8px;
        color: #2d5016;
        font-size: 0.9rem;
    }

    /* Info badges */
    .info-badge {
        display: inline-block;
        background: #e8f5e9;
        color: #2d5016;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-left: 8px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .wholesale-page {
            padding: 40px 0;
        }

        .form-row {
            flex-direction: column;
            gap: 25px;
        }
        
        .form-title {
            font-size: 2.2rem;
        }

        .form-subtitle {
            font-size: 1rem;
            margin-bottom: 40px;
        }

        .form-container {
            padding: 30px 25px;
            border-radius: 15px;
        }

        .form-description {
            padding: 20px;
            font-size: 1rem;
        }
        
        .phone-container {
            flex-direction: row;
        }
        
        .country-code {
            width: 90px;
        }

        .submit-btn {
            padding: 14px 40px;
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .form-title {
            font-size: 1.8rem;
        }

        .form-container {
            padding: 25px 20px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="url"],
        input[type="number"],
        textarea,
        select {
            padding: 12px 15px;
            font-size: 0.95rem;
        }
    }

    /* Animaciones */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-container {
        animation: fadeIn 0.6s ease-out;
    }

    /* Mejoras de accesibilidad */
    input:disabled,
    textarea:disabled,
    select:disabled {
        background-color: #e9ecef;
        cursor: not-allowed;
        opacity: 0.6;
    }
</style>

<div class="wholesale-page">
    <div class="container-form">
        <h1 class="form-title">Wholesale | Restaurants & Chefs</h1>
        <p class="form-subtitle">Partner with us for premium grass-fed beef at wholesale prices</p>
        
        <div class="form-container">
            @if(session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <p class="form-description">
                If you are a chef or restaurant and would like to create an account for wholesale pricing, please make an inquiry with the following form. We will respond within the next 24 business hours with further information. Thank you!
            </p>

            <form action="" method="POST">
                @csrf

                <!-- Fila 1: Nombre y Apellido -->
                <div class="form-row">
                    <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                        <label for="first_name">
                            <i class="fas fa-user label-icon"></i>First name<span class="required">*</span>
                        </label>
                        <input type="text" 
                               id="first_name" 
                               name="first_name" 
                               value="{{ old('first_name') }}" 
                               placeholder="Peter"
                               required>
                        @error('first_name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                        <label for="last_name">
                            <i class="fas fa-user label-icon"></i>Last name<span class="required">*</span>
                        </label>
                        <input type="text" 
                               id="last_name" 
                               name="last_name" 
                               value="{{ old('last_name') }}" 
                               placeholder="Green"
                               required>
                        @error('last_name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Fila 2: Email y Teléfono -->
                <div class="form-row">
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="email">
                            <i class="fas fa-envelope label-icon"></i>Email address<span class="required">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="name.last@example.com"
                               required>
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                        <label for="phone">
                            <i class="fas fa-phone label-icon"></i>Phone number<span class="required">*</span>
                        </label>
                        <div class="phone-container">
                            <select name="country_code" class="country-code" required>
                                <option value="+1" {{ old('country_code') == '+1' ? 'selected' : '' }}>+1</option>
                                <option value="+6" {{ old('country_code') == '+6' ? 'selected' : '' }}>+6</option>
                                <option value="+7" {{ old('country_code') == '+7' ? 'selected' : '' }}>+7</option>
                                <option value="+20" {{ old('country_code') == '+20' ? 'selected' : '' }}>+20</option>
                                <option value="+27" {{ old('country_code') == '+27' ? 'selected' : '' }}>+27</option>
                                <option value="+30" {{ old('country_code') == '+30' ? 'selected' : '' }}>+30</option>
                                <option value="+31" {{ old('country_code') == '+31' ? 'selected' : '' }}>+31</option>
                                <option value="+32" {{ old('country_code') == '+32' ? 'selected' : '' }}>+32</option>
                                <option value="+33" {{ old('country_code') == '+33' ? 'selected' : '' }}>+33</option>
                                <option value="+34" {{ old('country_code') == '+34' ? 'selected' : '' }}>+34</option>
                                <option value="+36" {{ old('country_code') == '+36' ? 'selected' : '' }}>+36</option>
                                <option value="+39" {{ old('country_code') == '+39' ? 'selected' : '' }}>+39</option>
                                <option value="+40" {{ old('country_code') == '+40' ? 'selected' : '' }}>+40</option>
                                <option value="+41" {{ old('country_code') == '+41' ? 'selected' : '' }}>+41</option>
                                <option value="+43" {{ old('country_code') == '+43' ? 'selected' : '' }}>+43</option>
                                <option value="+44" {{ old('country_code') == '+44' ? 'selected' : '' }}>+44</option>
                                <option value="+45" {{ old('country_code') == '+45' ? 'selected' : '' }}>+45</option>
                                <option value="+46" {{ old('country_code') == '+46' ? 'selected' : '' }}>+46</option>
                                <option value="+47" {{ old('country_code') == '+47' ? 'selected' : '' }}>+47</option>
                                <option value="+48" {{ old('country_code') == '+48' ? 'selected' : '' }}>+48</option>
                                <option value="+49" {{ old('country_code') == '+49' ? 'selected' : '' }}>+49</option>
                                <option value="+51" {{ old('country_code') == '+51' ? 'selected' : '' }}>+51</option>
                                <option value="+52" {{ old('country_code') == '+52' ? 'selected' : '' }}>+52</option>
                                <option value="+53" {{ old('country_code') == '+53' ? 'selected' : '' }}>+53</option>
                                <option value="+54" {{ old('country_code') == '+54' ? 'selected' : '' }}>+54</option>
                                <option value="+55" {{ old('country_code') == '+55' ? 'selected' : '' }}>+55</option>
                                <option value="+56" {{ old('country_code') == '+56' ? 'selected' : '' }}>+56</option>
                                <option value="+57" {{ old('country_code') == '+57' ? 'selected' : '' }}>+57</option>
                                <option value="+58" {{ old('country_code') == '+58' ? 'selected' : '' }}>+58</option>
                                <option value="+60" {{ old('country_code') == '+60' ? 'selected' : '' }}>+60</option>
                                <option value="+61" {{ old('country_code') == '+61' ? 'selected' : '' }}>+61</option>
                                <option value="+62" {{ old('country_code') == '+62' ? 'selected' : '' }}>+62</option>
                                <option value="+63" {{ old('country_code') == '+63' ? 'selected' : '' }}>+63</option>
                                <option value="+64" {{ old('country_code') == '+64' ? 'selected' : '' }}>+64</option>
                                <option value="+65" {{ old('country_code') == '+65' ? 'selected' : '' }}>+65</option>
                                <option value="+66" {{ old('country_code') == '+66' ? 'selected' : '' }}>+66</option>
                                <option value="+81" {{ old('country_code') == '+81' ? 'selected' : '' }}>+81</option>
                                <option value="+82" {{ old('country_code') == '+82' ? 'selected' : '' }}>+82</option>
                                <option value="+84" {{ old('country_code') == '+84' ? 'selected' : '' }}>+84</option>
                                <option value="+86" {{ old('country_code') == '+86' ? 'selected' : '' }}>+86</option>
                                <option value="+90" {{ old('country_code') == '+90' ? 'selected' : '' }}>+90</option>
                                <option value="+91" {{ old('country_code') == '+91' ? 'selected' : '' }}>+91</option>
                                <option value="+92" {{ old('country_code') == '+92' ? 'selected' : '' }}>+92</option>
                                <option value="+93" {{ old('country_code') == '+93' ? 'selected' : '' }}>+93</option>
                                <option value="+94" {{ old('country_code') == '+94' ? 'selected' : '' }}>+94</option>
                                <option value="+95" {{ old('country_code') == '+95' ? 'selected' : '' }}>+95</option>
                                <option value="+98" {{ old('country_code') == '+98' ? 'selected' : '' }}>+98</option>
                            </select>
                            <input type="tel" 
                                   name="phone" 
                                   class="phone-number" 
                                   value="{{ old('phone') }}" 
                                   placeholder="(123) 456-7890"
                                   required>
                        </div>
                        @error('phone')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Fila 3: Nombre de empresa y sitio web -->
                <div class="form-row">
                    <div class="form-group {{ $errors->has('company_name') ? 'has-error' : '' }}">
                        <label for="company_name">
                            <i class="fas fa-building label-icon"></i>Company name
                            <span class="info-badge">Optional</span>
                        </label>
                        <input type="text" 
                               id="company_name" 
                               name="company_name" 
                               value="{{ old('company_name') }}" 
                               placeholder="Wonka Chocolate Factory">
                        @error('company_name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group {{ $errors->has('company_website') ? 'has-error' : '' }}">
                        <label for="company_website">
                            <i class="fas fa-globe label-icon"></i>Company website
                            <span class="info-badge">Optional</span>
                        </label>
                        <input type="url" 
                               id="company_website" 
                               name="company_website" 
                               value="{{ old('company_website') }}" 
                               placeholder="https://wonkachocolatefactory.com">
                        @error('company_website')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Dirección de la empresa -->
                <div class="form-group full-width {{ $errors->has('company_address') ? 'has-error' : '' }}">
                    <label for="company_address">
                        <i class="fas fa-map-marker-alt label-icon"></i>Company address
                        <span class="info-badge">Optional</span>
                    </label>
                    <textarea name="company_address" 
                              id="company_address" 
                              placeholder="1234 Main St, New York, NY 10001, USA">{{ old('company_address') }}</textarea>
                    @error('company_address')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Años en el negocio -->
                <div class="form-group full-width {{ $errors->has('years_in_business') ? 'has-error' : '' }}">
                    <label for="years_in_business">
                        <i class="fas fa-calendar-alt label-icon"></i>Years in business
                        <span class="info-badge">Optional</span>
                    </label>
                    <input type="number" 
                           id="years_in_business" 
                           name="years_in_business" 
                           value="{{ old('years_in_business') }}" 
                           placeholder="12"
                           min="0"
                           max="100">
                    @error('years_in_business')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Botón de envío -->
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane" style="margin-right: 10px;"></i>Submit Application
                </button>
            </form>
        </div>
    </div>
</div>
@endsection