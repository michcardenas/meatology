@extends('layouts.app')

@section('title', 'About Us - Meatology')

@section('content')


<style>
        .container-form {
            max-width: 800px;
            margin: 0 auto;
            background-color: #011904;
        }

        .form-title {
            color: #d4c5a9;
            font-size: 2.5rem;
            font-weight: 300;
            text-align: center;
            margin-bottom: 40px;
            letter-spacing: 1px;
        }

        .form-container {
            background-color: rgba(0, 0, 0, 0.3);
            border: 2px solid #d4c5a9;
            border-radius: 10px;
            padding: 30px;
        }

        .form-description {
            color: #d4c5a9;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 30px;
            text-align: left;
        }

        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .form-group {
            flex: 1;
        }

        .form-group.full-width {
            width: 100%;
        }

        label {
            display: block;
            color: #d4c5a9;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .required {
            color: #ff6b6b;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="url"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 12px 15px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.95rem;
            color: #333;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #d4c5a9;
            box-shadow: 0 0 5px rgba(212, 197, 169, 0.3);
        }

        .phone-container {
            display: flex;
            gap: 10px;
        }

        .country-code {
            width: 80px;
            flex-shrink: 0;
        }

        .phone-number {
            flex: 1;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        .submit-btn {
            background-color: #8b7355;
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        .submit-btn:hover {
            background-color: #a08660;
        }

        .submit-btn:active {
            transform: translateY(1px);
        }

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 20px;
            }
            
            .form-title {
                font-size: 2rem;
            }
            
            .phone-container {
                flex-direction: column;
            }
            
            .country-code {
                width: 100%;
            }
        }

        /* Estilos para mensajes de error */
        .error-message {
            color: #ff6b6b;
            font-size: 0.85rem;
            margin-top: 5px;
        }

        .form-group.has-error input,
        .form-group.has-error select,
        .form-group.has-error textarea {
            border-color: #ff6b6b;
        }
    </style>

    <div class="container-form">
        <h1 class="form-title">Wholesale | Restaurants & Chefs</h1>
        
        <div class="form-container">
            <p class="form-description">
                If you are a chef or restaurant and would like to create an account for wholesale pricing, please make an inquiry with the following form. We will respond within the next 24 business hours with further information. Thank you!
            </p>

            <form action="{{ route('wholesale.submit') }}" method="POST">
                @csrf

                <!-- Fila 1: Nombre y Apellido -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name">First name<span class="required">*</span></label>
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
                    
                    <div class="form-group">
                        <label for="last_name">Last name<span class="required">*</span></label>
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
                    <div class="form-group">
                        <label for="email">Email address<span class="required">*</span></label>
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
                    
                    <div class="form-group">
                        <label for="phone">Phone number<span class="required">*</span></label>
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
                    <div class="form-group">
                        <label for="company_name">Company name</label>
                        <input type="text" 
                               id="company_name" 
                               name="company_name" 
                               value="{{ old('company_name') }}" 
                               placeholder="Wonka Chocolate Factory">
                        @error('company_name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="company_website">Company website</label>
                        <input type="url" 
                               id="company_website" 
                               name="company_website" 
                               value="{{ old('company_website') }}" 
                               placeholder="wonkachocolatefactory.com">
                        @error('company_website')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Dirección de la empresa -->
                <div class="form-group full-width">
                    <label for="company_address">Company address</label>
                    <textarea name="company_address" 
                              id="company_address" 
                              placeholder="1234 Main St, New York, USA">{{ old('company_address') }}</textarea>
                    @error('company_address')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Años en el negocio -->
                <div class="form-group full-width">
                    <label for="years_in_business">Years in business</label>
                    <input type="number" 
                           id="years_in_business" 
                           name="years_in_business" 
                           value="{{ old('years_in_business') }}" 
                           placeholder="12"
                           min="0">
                    @error('years_in_business')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Botón de envío -->
                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </div>
    </div>
@endsection