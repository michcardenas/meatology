{{-- Vista: resources/views/shop/checkout.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>🛒 Checkout</h2>
                @if(isset($totalSavings) && $totalSavings > 0)
                    <div class="badge bg-success fs-6 px-3 py-2">
                        🏷️ You're saving ${{ number_format($totalSavings, 2, '.', ',') }}!
                    </div>
                @endif
            </div>
            
            <div class="row">
                <!-- Información del pedido -->
                <div class="col-md-8">
                    <div class="card mb-4 {{ isset($totalSavings) && $totalSavings > 0 ? 'border-success' : '' }}">
                        <div class="card-header">
                            <h5>📦 Order Details</h5>
                            @if(isset($totalSavings) && $totalSavings > 0)
                                <small class="text-success">🎉 Items with discounts applied</small>
                            @endif
                        </div>
                        <div class="card-body">
                            @foreach($cartItems as $item)
                                <div class="row align-items-center mb-3 pb-3 border-bottom {{ isset($item->options->descuento) && $item->options->descuento > 0 ? 'bg-success bg-opacity-10' : '' }}">
                                    <div class="col-md-2">
                                        <div class="position-relative">
                                            <img src="{{ $item->options->image ? Storage::url($item->options->image) : asset('images/placeholder.jpg') }}" 
                                                 class="img-fluid rounded" alt="{{ $item->name }}">
                                            @if(isset($item->options->descuento) && $item->options->descuento > 0)
                                                <span class="position-absolute top-0 start-0 badge bg-danger m-1 small">
                                                    -{{ $item->options->descuento }}%
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center gap-2">
                                            <h6>{{ $item->name }}</h6>
                                            @if(isset($item->options->descuento) && $item->options->descuento > 0)
                                                <span class="badge bg-danger">-{{ $item->options->descuento }}% OFF</span>
                                            @endif
                                        </div>
                                        <small class="text-muted">{{ $item->options->category_name }}</small>
                                        <br>
                                        
                                        @if(isset($item->options->descuento) && $item->options->descuento > 0)
                                            <small class="text-muted text-decoration-line-through">
                                                Original: ${{ number_format($item->options->original_price, 2, '.', ',') }} × {{ $item->qty }}
                                            </small>
                                            <br>
                                            <small class="text-success fw-bold">
                                                Discounted: ${{ number_format($item->price, 2, '.', ',') }} × {{ $item->qty }}
                                            </small>
                                            <br>
                                            <small class="text-success">
                                                You save: ${{ number_format($item->options->discount_amount * $item->qty, 2, '.', ',') }}
                                            </small>
                                        @else
                                            <small class="text-muted">Qty: {{ $item->qty }} × ${{ number_format($item->price, 2, '.', ',') }}</small>
                                        @endif
                                    </div>
                                    <div class="col-md-4 text-end">
                                        @if(isset($item->options->descuento) && $item->options->descuento > 0)
                                            <div class="text-muted text-decoration-line-through small">
                                                ${{ number_format($item->options->original_price * $item->qty, 2, '.', ',') }}
                                            </div>
                                            <strong class="text-danger">${{ number_format($item->total, 2, '.', ',') }}</strong>
                                        @else
                                            <strong>${{ number_format($item->total, 2, '.', ',') }}</strong>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            
                            {{-- Resumen de ahorros en productos --}}
                          
                        </div>
                    </div>

                    <!-- Sección de ubicación de envío -->
<div class="card mb-4">
    <div class="card-header">
        <h5>🚚 Shipping Location</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <label class="form-label fw-bold">State *</label>
                <select id="shipping-country" name="shipping_country" class="form-select" required>
                    <option value="">-- Select State --</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" data-cities="{{ $country->cities->toJson() }}">
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">City</label>
                <select id="shipping-city" name="shipping_city" class="form-select">
                    <option value="">-- Select State First --</option>
                </select>
                <small class="text-muted">Optional - for shipping cost calculation</small>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Postal Code</label>
                <input type="text" 
                       id="codigo-postal" 
                       name="codigo_postal" 
                       class="form-control" 
                       placeholder="Enter postal code"
                       maxlength="20">
                <small class="text-muted">Optional</small>
            </div>
        </div>
        <div class="mt-3">
            <small class="text-muted">
                📍 Tax rates are calculated by state. Shipping costs are calculated by city (if available)
            </small>
        </div>
    </div>
</div>

                    <!-- Información de envío/contacto -->
                    <div class="card">
                        <div class="card-header">
                            <h5>📍 Contact Information</h5>
                        </div>
                        <div class="card-body">
                            @if($isAuthenticated)
                                <!-- Usuario autenticado -->
                                <div class="alert alert-info">
                                    <h6>Welcome back, {{ $user->name }}!</h6>
                                    <p class="mb-0">Email: {{ $user->email }}</p>
                                </div>

                                <form id="checkoutForm" action="{{ route('order.process') }}" method="POST">
                                    @csrf
                                    <input type="hidden" id="final-country" name="country_id">
                                    <input type="hidden" id="final-city" name="city_id">
                                    <input type="hidden" id="final-total" name="total">
                                    <input type="hidden" id="final-tax" name="tax">
                                    <input type="hidden" id="final-shipping" name="shipping">
                                    <input type="hidden" id="applied-discount-code" name="discount_code">
                                    <input type="hidden" id="applied-discount-amount" name="discount_amount">
                                    <input type="hidden" id="final-tip-amount" name="tip_amount" value="0">
                                    <input type="hidden" id="final-tip-percentage" name="tip_percentage">
                                    {{-- Agregar información de descuentos de productos --}}
                                    <input type="hidden" name="product_savings" value="{{ $totalSavings ?? 0 }}">
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Address *</label>
                                            <textarea name="address" class="form-control" rows="3" placeholder="Enter your complete address" required>{{ old('address', $user->address ?? '') }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Phone *</label>
                                            <input type="tel" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? '') }}" placeholder="Your phone number" required>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Special Instructions (Optional)</label>
                                            <textarea name="notes" class="form-control" rows="2" placeholder="Any special instructions for your order">{{ old('notes') }}</textarea>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <!-- Usuario no autenticado -->
                                <div class="alert alert-warning">
                                    <h6>Guest Checkout</h6>
                                    <p class="mb-0">Please provide your contact and shipping information</p>
                                </div>

                                <form id="checkoutFormGuest" action="{{ route('order.process') }}" method="POST">
                                    @csrf
                                    <input type="hidden" id="final-country-guest" name="country_id">
                                    <input type="hidden" id="final-city-guest" name="city_id">
                                    <input type="hidden" id="final-total-guest" name="total">
                                    <input type="hidden" id="final-tax-guest" name="tax">
                                    <input type="hidden" id="final-shipping-guest" name="shipping">
                                    <input type="hidden" id="applied-discount-code-guest" name="discount_code">
                                    <input type="hidden" id="applied-discount-amount-guest" name="discount_amount">
                                    <input type="hidden" id="final-tip-amount-guest" name="tip_amount" value="0">
                                    <input type="hidden" id="final-tip-percentage-guest" name="tip_percentage">
                                    {{-- Agregar información de descuentos de productos --}}
                                    <input type="hidden" name="product_savings" value="{{ $totalSavings ?? 0 }}">
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Full Name *</label>
                                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Your full name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email *</label>
                                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="your.email@example.com" required>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Phone *</label>
                                            <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="Your phone number" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Address *</label>
                                            <textarea name="address" class="form-control" rows="3" placeholder="Enter your complete address" required>{{ old('address') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Special Instructions (Optional)</label>
                                            <textarea name="notes" class="form-control" rows="2" placeholder="Any special instructions for your order">{{ old('notes') }}</textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <small class="text-muted">
                                            <a href="{{ route('login') }}">Already have an account? Login here</a> | 
                                            <a href="{{ route('register') }}">Create account for faster checkout</a>
                                        </small>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Resumen del pedido -->
                <div class="col-md-4">
                    <div class="card sticky-top {{ isset($totalSavings) && $totalSavings > 0 ? 'border-success' : '' }}">
                        @if(isset($totalSavings) && $totalSavings > 0)
                            <div class="card-header bg-success text-white text-center">
                                <strong>💰 Order Summary - With Savings!</strong>
                            </div>
                        @else
                            <div class="card-header">
                                <h5>💰 Order Summary</h5>
                            </div>
                        @endif
                        <div class="card-body">
                            {{-- Mostrar ahorros de productos primero --}}
                            @if(isset($totalSavings) && $totalSavings > 0)
                             
                                
                                <div class="d-flex justify-content-between mb-2 text-muted text-decoration-line-through">
                                    <span>Original subtotal:</span>
                                    <span>${{ number_format($originalSubtotal ?? 0, 2, '.', ',') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2 text-success fw-bold">
                                    <span>Product savings:</span>
                                    <span>-${{ number_format($totalSavings, 2, '.', ',') }}</span>
                                </div>
                                <hr class="my-2">
                            @endif
                            
                            <!-- Sección de descuento adicional -->
                            <div class="mb-3 p-3 bg-light rounded">
                                <h6 class="mb-2">🎫 Additional Discount Code</h6>
                                <div class="input-group mb-2">
                                    <input type="text" id="discount-code" class="form-control" 
                                        placeholder="Enter discount code" style="text-transform: uppercase;">
                                    <button type="button" id="apply-discount-btn" class="btn btn-outline-primary">
                                        Apply
                                    </button>
                                </div>
                                
                                <!-- Estado del descuento -->
                                <div id="discount-status" style="display: none;">
                                    <!-- Se llena dinámicamente -->
                                </div>
                                
                                <!-- Botón para remover descuento -->
                                <button type="button" id="remove-discount-btn" class="btn btn-sm btn-outline-danger w-100" 
                                        style="display: none;">
                                    Remove Discount
                                </button>
                            </div>

                            <!-- Sección de propinas -->
                            <div class="mb-3 p-3 bg-light rounded">
                                <h6 class="mb-3">💝 Add Tip for Our Team</h6>
                                
                                <!-- Botones de porcentajes predefinidos -->
                                <div class="row mb-3">
                                    <div class="col-3">
                                        <button type="button" class="btn btn-outline-success w-100 tip-btn" data-percentage="15">
                                            15%
                                        </button>
                                    </div>
                                    <div class="col-3">
                                        <button type="button" class="btn btn-outline-success w-100 tip-btn" data-percentage="18">
                                            18%
                                        </button>
                                    </div>
                                    <div class="col-3">
                                        <button type="button" class="btn btn-outline-success w-100 tip-btn" data-percentage="20">
                                            20%
                                        </button>
                                    </div>
                                    <div class="col-3">
                                        <button type="button" class="btn btn-outline-success w-100 tip-btn" data-percentage="25">
                                            25%
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Monto personalizado -->
                                <div class="mb-2">
                                    <label class="form-label small">Custom Amount:</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" id="custom-tip" class="form-control" 
                                               placeholder="0.00" step="0.01" min="0">
                                    </div>
                                </div>
                                
                                <!-- Estado del tip -->
                                <div id="tip-display" class="text-center text-success fw-bold" style="display: none;">
                                    Tip: $<span id="tip-amount-display">0.00</span>
                                </div>
                                
                                <!-- Botón para remover tip -->
                                <button type="button" id="remove-tip-btn" class="btn btn-sm btn-outline-danger w-100 mt-2" 
                                        style="display: none;">
                                    Remove Tip
                                </button>
                            </div>

                            <!-- Resumen de costos -->
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span id="display-subtotal">${{ number_format($subtotal, 2, '.', ',') }}</span>
                            </div>
                            
                            <!-- Línea de descuento adicional (oculta inicialmente) -->
                            <div id="discount-line" class="d-flex justify-content-between mb-2 text-success" style="display: none;">
                                <span id="discount-label">Additional Discount:</span>
                                <span id="discount-amount">-$0.00</span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax:</span>
                                <span id="display-tax">$0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping:</span>
                                <span id="display-shipping">Select state</span>
                            </div>
                            
                            <!-- Línea de propina -->
                            <div id="tip-line" class="d-flex justify-content-between mb-2" style="display: none;">
                                <span>Tip:</span>
                                <span id="display-tip">$0.00</span>
                            </div>
                            
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Total:</strong>
                                <strong id="display-total">${{ number_format($subtotal, 2, '.', ',') }}</strong>
                            </div>
                            
                            @if(isset($totalSavings) && $totalSavings > 0)
                                <div class="alert alert-info py-2 text-center">
                                    <small><strong>🎯 Total Savings: ${{ number_format($totalSavings, 2, '.', ',') }}</strong></small>
                                </div>
                            @endif
                            
                            <div id="location-warning" class="alert alert-warning" style="display: none;">
                                📍 Please select a state to see shipping costs and complete your order
                            </div>
                            
                            <button type="submit" class="btn btn-success w-100 mb-2" id="place-order-btn" disabled>
                                💳 Place Order
                                @if(isset($totalSavings) && $totalSavings > 0)
                                    <br><small>With ${{ number_format($totalSavings, 2, '.', ',') }} in savings!</small>
                                @endif
                            </button>
                            
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100">
                                ← Back to Cart
                            </a>
                            
                            <div class="mt-3 text-center">
                                <small class="text-muted">
                                    🔒 Secure checkout <br>
                                    💚 Fresh meat guarantee
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// 🔥 Generar datos del carrito en PHP y asignarlos a variable global
window.cartItemsData = {!! json_encode($cartItems->map(function($item) {
    return [
        'id' => $item->id,
        'name' => $item->name,
        'price' => $item->price,
        'qty' => $item->qty,
        'options' => $item->options
    ];
})) !!};

document.addEventListener('DOMContentLoaded', function() {
    // 🔥 Detectar cuál formulario usar basado en si el usuario está autenticado
    const isAuthenticated = {{ $isAuthenticated ? 'true' : 'false' }};
    const formSuffix = isAuthenticated ? '' : '-guest';

    // Función auxiliar para obtener elementos con sufijo correcto
    function getElementWithSuffix(baseId) {
        const element = document.getElementById(baseId + formSuffix);
        if (!element) {
            console.warn(`Elemento no encontrado: ${baseId + formSuffix}`);
        }
        return element;
    }

    // Función para obtener el formulario correcto
    function getCorrectForm() {
        return document.getElementById(isAuthenticated ? 'checkoutForm' : 'checkoutFormGuest');
    }

    // Elementos del DOM - Verificar que existan
    const countrySelect = document.getElementById('shipping-country');
    const citySelect = document.getElementById('shipping-city');
    const placeOrderBtn = document.getElementById('place-order-btn');
    const locationWarning = document.getElementById('location-warning');
    const discountCodeInput = document.getElementById('discount-code');
    const applyDiscountBtn = document.getElementById('apply-discount-btn');
    const removeDiscountBtn = document.getElementById('remove-discount-btn');
    const discountStatus = document.getElementById('discount-status');
    const discountLine = document.getElementById('discount-line');
    const discountLabel = document.getElementById('discount-label');
    const discountAmount = document.getElementById('discount-amount');
    
    // Verificar elementos críticos
    if (!placeOrderBtn) {
        console.error('Botón de orden no encontrado');
        return;
    }
    
    // Variables globales
    const originalSubtotal = parseFloat('{{ $subtotal }}');
    let currentDiscount = 0;
    let appliedDiscountData = null;
    
    // Variables para propinas
    let currentTip = 0;
    let currentTipPercentage = null;

    // Elementos del DOM para propinas
    const tipButtons = document.querySelectorAll('.tip-btn');
    const customTipInput = document.getElementById('custom-tip');
    const removeTipBtn = document.getElementById('remove-tip-btn');
    const tipDisplay = document.getElementById('tip-display');
    const tipLine = document.getElementById('tip-line');
    const displayTip = document.getElementById('display-tip');
    const tipAmountDisplay = document.getElementById('tip-amount-display');
    
    console.log('Subtotal with product discounts:', originalSubtotal);
    console.log('Product savings:', parseFloat('{{ $totalSavings ?? 0 }}'));
    
    // 🔥 CAMBIO IMPORTANTE: NO mostrar advertencia y HABILITAR el botón desde el inicio
    if (locationWarning) {
        locationWarning.style.display = 'none';
    }
    placeOrderBtn.disabled = false;

    // Establecer valores por defecto al cargar
    setDefaultValues();

    // 🔥 🔥 🔥 CORRECCIÓN PRINCIPAL: Event listener para el botón de envío
    placeOrderBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const form = getCorrectForm();
        
        if (!form) {
            console.error('Formulario no encontrado');
            alert('Error al procesar el pedido. Por favor recarga la página.');
            return;
        }
        
        // Validar campos requeridos antes de enviar
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        let firstInvalidField = null;
        
        requiredFields.forEach(field => {
            if (!field.value || field.value.trim() === '') {
                field.classList.add('is-invalid');
                if (!firstInvalidField) {
                    firstInvalidField = field;
                }
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            alert('Please complete all required fields');
            if (firstInvalidField) {
                firstInvalidField.focus();
            }
            return;
        }
        
        // Log para debugging
        console.log('=== ENVIANDO FORMULARIO ===');
        console.log('Form ID:', form.id);
        console.log('Form Action:', form.action);
        console.log('Form Method:', form.method);
        console.log('Datos a enviar:', {
            country: getElementWithSuffix('final-country')?.value || '',
            city: getElementWithSuffix('final-city')?.value || '',
            total: getElementWithSuffix('final-total')?.value || '',
            tax: getElementWithSuffix('final-tax')?.value || '',
            shipping: getElementWithSuffix('final-shipping')?.value || '',
            discount_code: getElementWithSuffix('applied-discount-code')?.value || '',
            discount_amount: getElementWithSuffix('applied-discount-amount')?.value || '',
            tip_amount: getElementWithSuffix('final-tip-amount')?.value || '0'
        });
        
        // Deshabilitar el botón para evitar doble envío
        placeOrderBtn.disabled = true;
        placeOrderBtn.innerHTML = '⏳ Processing order...';
        
        // IMPORTANTE: Usar HTMLFormElement.submit() directamente
        try {
            // Asegurarse de que los campos ocultos tengan valores
            if (!getElementWithSuffix('final-total').value) {
                const subtotalConDescuento = originalSubtotal - currentDiscount;
                const total = subtotalConDescuento + currentTip;
                getElementWithSuffix('final-total').value = total.toFixed(2);
            }
            
            // Enviar el formulario
            console.log('Enviando formulario ahora...');
            form.submit();
            
        } catch (error) {
            console.error('Error al enviar:', error);
            placeOrderBtn.disabled = false;
            placeOrderBtn.innerHTML = '💳 Place Order';
            alert('Error processing order. Please try again.');
        }
    });

    // 🎫 Manejar aplicación de descuento adicional
    if (applyDiscountBtn) {
        applyDiscountBtn.addEventListener('click', function() {
            const codigo = discountCodeInput.value.trim().toUpperCase();
            
            if (!codigo) {
                showDiscountMessage('❌ Please enter a discount code', 'error');
                return;
            }
            
            // Usar datos del carrito desde variable global
            const cartItems = window.cartItemsData;
            
            // Mostrar loading
            applyDiscountBtn.textContent = 'Validating...';
            applyDiscountBtn.disabled = true;
            
            fetch('{{ route("checkout.validate-discount") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    codigo: codigo,
                    subtotal: originalSubtotal,
                    cart_items: cartItems
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Aplicar descuento
                    appliedDiscountData = data.descuento;
                    currentDiscount = appliedDiscountData.monto;
                    
                    // Actualizar UI
                    showDiscountMessage(data.message, 'success');
                    showDiscountLine();
                    updateTotals();
                    
                    // Mostrar botón de remover
                    removeDiscountBtn.style.display = 'block';
                    discountCodeInput.disabled = true;
                    applyDiscountBtn.style.display = 'none';
                    
                    // Actualizar campos ocultos
                    const discountCodeField = getElementWithSuffix('applied-discount-code');
                    const discountAmountField = getElementWithSuffix('applied-discount-amount');
                    if (discountCodeField) discountCodeField.value = appliedDiscountData.codigo;
                    if (discountAmountField) discountAmountField.value = currentDiscount.toFixed(2);
                    
                } else {
                    showDiscountMessage(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showDiscountMessage('❌ Error validating discount code', 'error');
            })
            .finally(() => {
                applyDiscountBtn.textContent = 'Apply';
                applyDiscountBtn.disabled = false;
            });
        });
    }
    
    // 🗑️ Manejar remoción de descuento
    if (removeDiscountBtn) {
        removeDiscountBtn.addEventListener('click', function() {
            removeDiscount();
        });
    }

    // 💝 Manejar botones de porcentaje de propina
    tipButtons.forEach(button => {
        button.addEventListener('click', function() {
            const percentage = parseFloat(this.dataset.percentage);
            applyTipPercentage(percentage);
            
            // Activar botón seleccionado
            tipButtons.forEach(btn => {
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-success');
            });
            this.classList.remove('btn-outline-success');
            this.classList.add('btn-success');
            
            // Limpiar input custom
            if (customTipInput) customTipInput.value = '';
        });
    });

    // Manejar monto personalizado
    if (customTipInput) {
        customTipInput.addEventListener('input', function() {
            const customAmount = parseFloat(this.value) || 0;
            applyCustomTip(customAmount);
            
            // Desactivar botones de porcentaje
            tipButtons.forEach(btn => {
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-success');
            });
        });
    }

    // Remover propina
    if (removeTipBtn) {
        removeTipBtn.addEventListener('click', function() {
            removeTip();
        });
    }
    
    // 📍 Manejar cambio de país
    if (countrySelect) {
        countrySelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const cities = selectedOption.dataset.cities ? JSON.parse(selectedOption.dataset.cities) : [];
            
            // Limpiar ciudades
            if (citySelect) {
                citySelect.innerHTML = '<option value="">-- Optional: Select City for tax calculation --</option>';
                
                // Agregar ciudades
                cities.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.id;
                    option.textContent = city.name;
                    citySelect.appendChild(option);
                });
            }
            
            // Calcular costos
            if (this.value) {
                calculateCosts();
            } else {
                setDefaultValues();
            }
        });
    }
    
    // Manejar cambio de ciudad
    if (citySelect) {
        citySelect.addEventListener('change', function() {
            if (countrySelect && countrySelect.value) {
                calculateCosts();
            }
        });
    }
    
    // 🆕 Función para establecer valores por defecto
    function setDefaultValues() {
        const subtotalConDescuento = originalSubtotal - currentDiscount;
        const defaultTax = 0;
        const defaultShipping = 0;
        const total = subtotalConDescuento + defaultTax + defaultShipping + currentTip;
        
        // Actualizar display
        const displayTax = document.getElementById('display-tax');
        const displayShipping = document.getElementById('display-shipping');
        const displayTotal = document.getElementById('display-total');
        
        if (displayTax) displayTax.textContent = '$' + defaultTax.toFixed(2);
        if (displayShipping) displayShipping.textContent = 'Free';
        if (displayTotal) displayTotal.textContent = '$' + total.toFixed(2);
        
        // Actualizar campos ocultos
        const countryField = getElementWithSuffix('final-country');
        const cityField = getElementWithSuffix('final-city');
        const totalField = getElementWithSuffix('final-total');
        const taxField = getElementWithSuffix('final-tax');
        const shippingField = getElementWithSuffix('final-shipping');
        
        if (countryField) countryField.value = '';
        if (cityField) cityField.value = '';
        if (totalField) totalField.value = total.toFixed(2);
        if (taxField) taxField.value = defaultTax.toFixed(2);
        if (shippingField) shippingField.value = defaultShipping.toFixed(2);
        
        // Mantener el botón habilitado
        placeOrderBtn.disabled = false;
        if (locationWarning) locationWarning.style.display = 'none';
        
        console.log('Default values set:', {
            subtotal: subtotalConDescuento,
            tax: defaultTax,
            shipping: defaultShipping,
            tip: currentTip,
            total: total
        });
    }
    
    // 🧮 Función de cálculo de costos
    function calculateCosts() {
        if (!countrySelect) return;
        
        const countryId = countrySelect.value;
        const cityId = citySelect ? citySelect.value : '';
        
        if (!countryId) {
            setDefaultValues();
            return;
        }
        
        // Mostrar loading
        const displayTax = document.getElementById('display-tax');
        const displayShipping = document.getElementById('display-shipping');
        const displayTotal = document.getElementById('display-total');
        
        if (displayTax) displayTax.textContent = 'Calculating...';
        if (displayShipping) displayShipping.textContent = 'Calculating...';
        if (displayTotal) displayTotal.textContent = 'Calculating...';
        
        const subtotalConDescuento = originalSubtotal - currentDiscount;
        
        // Verificar CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            console.error('CSRF token not found!');
            alert('Security token missing. Please refresh the page.');
            return;
        }
        
        console.log('Sending request with:', {
            country_id: countryId,
            city_id: cityId,
            subtotal: subtotalConDescuento,
            url: '{{ route("checkout.calculate") }}'
        });
        
        fetch('{{ route("checkout.calculate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                country_id: countryId,
                city_id: cityId,
                subtotal: subtotalConDescuento
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Parsed data:', data);
            
            const tax = parseFloat(data.tax_raw || 0);
            const shipping = parseFloat(data.shipping_raw || 0);
            const total = subtotalConDescuento + tax + shipping + currentTip;
            
            // Actualizar display
            if (displayTax) displayTax.textContent = '$' + tax.toFixed(2);
            if (displayShipping) displayShipping.textContent = '$' + shipping.toFixed(2);
            if (displayTotal) displayTotal.textContent = '$' + total.toFixed(2);
            
            // Actualizar campos ocultos
            const countryField = getElementWithSuffix('final-country');
            const cityField = getElementWithSuffix('final-city');
            const totalField = getElementWithSuffix('final-total');
            const taxField = getElementWithSuffix('final-tax');
            const shippingField = getElementWithSuffix('final-shipping');
            
            if (countryField) countryField.value = countryId;
            if (cityField) cityField.value = cityId;
            if (totalField) totalField.value = total.toFixed(2);
            if (taxField) taxField.value = tax.toFixed(2);
            if (shippingField) shippingField.value = shipping.toFixed(2);
            
            // Mantener el botón habilitado
            placeOrderBtn.disabled = false;
            if (locationWarning) locationWarning.style.display = 'none';
            
            console.log('Calculation successful:', {
                subtotal: subtotalConDescuento,
                tax: tax,
                shipping: shipping,
                tip: currentTip,
                total: total
            });
        })
        .catch(error => {
            console.error('Error in calculateCosts:', error);
            setDefaultValues();
            console.log('Using default shipping values due to calculation error');
        });
    }
    
    function updateTotals() {
        if (countrySelect && countrySelect.value) {
            calculateCosts();
        } else {
            setDefaultValues();
        }
    }

    // Funciones de propinas
    function applyTipPercentage(percentage) {
        const subtotalConDescuento = originalSubtotal - currentDiscount;
        currentTip = subtotalConDescuento * (percentage / 100);
        currentTipPercentage = percentage;
        
        updateTipDisplay();
        updateTotals();
    }

    function applyCustomTip(amount) {
        currentTip = amount;
        currentTipPercentage = null;
        
        updateTipDisplay();
        updateTotals();
    }

    function removeTip() {
        currentTip = 0;
        currentTipPercentage = null;
        if (customTipInput) customTipInput.value = '';
        
        // Desactivar botones
        tipButtons.forEach(btn => {
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-success');
        });
        
        updateTipDisplay();
        updateTotals();
    }

    function updateTipDisplay() {
        if (currentTip > 0) {
            if (tipAmountDisplay) tipAmountDisplay.textContent = currentTip.toFixed(2);
            if (displayTip) displayTip.textContent = '$' + currentTip.toFixed(2);
            if (tipDisplay) tipDisplay.style.display = 'block';
            if (tipLine) tipLine.style.display = 'flex';
            if (removeTipBtn) removeTipBtn.style.display = 'block';
            
            // Actualizar campos ocultos
            const tipAmountField = getElementWithSuffix('final-tip-amount');
            const tipPercentageField = getElementWithSuffix('final-tip-percentage');
            
            if (tipAmountField) tipAmountField.value = currentTip.toFixed(2);
            if (tipPercentageField) tipPercentageField.value = currentTipPercentage || '';
        } else {
            if (tipDisplay) tipDisplay.style.display = 'none';
            if (tipLine) tipLine.style.display = 'none';
            if (removeTipBtn) removeTipBtn.style.display = 'none';
            
            // Limpiar campos ocultos
            const tipAmountField = getElementWithSuffix('final-tip-amount');
            const tipPercentageField = getElementWithSuffix('final-tip-percentage');
            
            if (tipAmountField) tipAmountField.value = '0';
            if (tipPercentageField) tipPercentageField.value = '';
        }
    }
    
    function showDiscountLine() {
        if (appliedDiscountData && discountLabel && discountAmount && discountLine) {
            discountLabel.textContent = `Additional Discount (${appliedDiscountData.codigo} - ${appliedDiscountData.porcentaje}%):`;
            discountAmount.textContent = '-$' + currentDiscount.toFixed(2);
            discountLine.style.display = 'flex';
        }
    }
    
    function removeDiscount() {
        currentDiscount = 0;
        appliedDiscountData = null;
        
        // Limpiar UI
        if (discountLine) discountLine.style.display = 'none';
        if (discountStatus) discountStatus.style.display = 'none';
        if (removeDiscountBtn) removeDiscountBtn.style.display = 'none';
        if (applyDiscountBtn) applyDiscountBtn.style.display = 'block';
        if (discountCodeInput) {
            discountCodeInput.disabled = false;
            discountCodeInput.value = '';
        }
        
        // Limpiar campos ocultos
        const discountCodeField = getElementWithSuffix('applied-discount-code');
        const discountAmountField = getElementWithSuffix('applied-discount-amount');
        
        if (discountCodeField) discountCodeField.value = '';
        if (discountAmountField) discountAmountField.value = '';
        
        updateTotals();
    }
    
    function showDiscountMessage(message, type) {
        if (discountStatus) {
            discountStatus.innerHTML = `
                <div class="alert alert-${type === 'success' ? 'success' : 'danger'} alert-sm mb-2">
                    ${message}
                    ${appliedDiscountData ? `<br><small>Applies to: ${appliedDiscountData.productos.join(', ')}</small>` : ''}
                </div>
            `;
            discountStatus.style.display = 'block';
        }
    }
    
    // Permitir aplicar descuento con Enter
    if (discountCodeInput) {
        discountCodeInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (applyDiscountBtn) applyDiscountBtn.click();
            }
        });
    }
});

// Protección contra errores adicionales que puedan existir después de este script
window.addEventListener('error', function(e) {
    if (e.message && e.message.includes('classList')) {
        console.warn('Error de classList capturado:', e.message);
        e.preventDefault();
    }
});</script>
@endsection