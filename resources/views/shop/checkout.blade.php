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
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Country *</label>
                                    <select id="shipping-country" name="shipping_country" class="form-select" required>
                                        <option value="">-- Select Country --</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" data-cities="{{ $country->cities->toJson() }}">
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">City</label>
                                    <select id="shipping-city" name="shipping_city" class="form-select">
                                        <option value="">-- Select Country First --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-3">
                                <small class="text-muted">
                                    📍 Shipping costs and taxes will be calculated based on your location
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
                                
                                <form id="checkoutForm" action="{{ route('order.process') }}" method="POST">
                                    @csrf
                                    <input type="hidden" id="final-country" name="country_id">
                                    <input type="hidden" id="final-city" name="city_id">
                                    <input type="hidden" id="final-total" name="total">
                                    <input type="hidden" id="final-tax" name="tax">
                                    <input type="hidden" id="final-shipping" name="shipping">
                                    <input type="hidden" id="applied-discount-code" name="discount_code">
                                    <input type="hidden" id="applied-discount-amount" name="discount_amount">
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
                                <span id="display-shipping">Select location</span>
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
                                📍 Please select shipping location to see final costs
                            </div>
                            
                            <button type="submit" form="checkoutForm" class="btn btn-success w-100 mb-2" id="place-order-btn" disabled>
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
    // Elementos del DOM
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
    
    // Variables globales
    const originalSubtotal = parseFloat('{{ $subtotal }}');
    let currentDiscount = 0;
    let appliedDiscountData = null;
    
    console.log('Subtotal with product discounts:', originalSubtotal);
    console.log('Product savings:', parseFloat('{{ $totalSavings ?? 0 }}'));
    
    // Mostrar advertencia inicialmente
    locationWarning.style.display = 'block';

    // 🎫 Manejar aplicación de descuento adicional
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
                document.getElementById('applied-discount-code').value = appliedDiscountData.codigo;
                document.getElementById('applied-discount-amount').value = currentDiscount.toFixed(2);
                
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
    
    // 🗑️ Manejar remoción de descuento
    removeDiscountBtn.addEventListener('click', function() {
        removeDiscount();
    });
    
    // 📍 Manejar cambio de país
    countrySelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const cities = selectedOption.dataset.cities ? JSON.parse(selectedOption.dataset.cities) : [];
        
        // Limpiar ciudades
        citySelect.innerHTML = '<option value="">-- Select City --</option>';
        
        // Agregar ciudades
        cities.forEach(city => {
            const option = document.createElement('option');
            option.value = city.id;
            option.textContent = city.name;
            citySelect.appendChild(option);
        });
        
        // Calcular costos si hay país seleccionado
        if (this.value) {
            calculateCosts();
        } else {
            resetCosts();
        }
    });
    
    // Manejar cambio de ciudad
    citySelect.addEventListener('change', function() {
        if (countrySelect.value) {
            calculateCosts();
        }
    });
    
    // 🧮 Funciones de cálculo
    function calculateCosts() {
        const countryId = countrySelect.value;
        const cityId = citySelect.value;
        
        if (!countryId) return;
        
        // Mostrar loading
        document.getElementById('display-tax').textContent = 'Calculating...';
        document.getElementById('display-shipping').textContent = 'Calculating...';
        document.getElementById('display-total').textContent = 'Calculating...';
        
        const subtotalConDescuento = originalSubtotal - currentDiscount;
        
        fetch('{{ route("checkout.calculate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                country_id: countryId,
                city_id: cityId,
                subtotal: subtotalConDescuento
            })
        })
        .then(response => response.json())
        .then(data => {
            const tax = parseFloat(data.tax_raw || 0);
            const shipping = parseFloat(data.shipping_raw || 0);
            const total = subtotalConDescuento + tax + shipping;
            
            // Actualizar display
            document.getElementById('display-tax').textContent = '$' + tax.toFixed(2);
            document.getElementById('display-shipping').textContent = '$' + shipping.toFixed(2);
            document.getElementById('display-total').textContent = '$' + total.toFixed(2);
            
            // Actualizar campos ocultos
            document.getElementById('final-country').value = countryId;
            document.getElementById('final-city').value = cityId;
            document.getElementById('final-total').value = total.toFixed(2);
            document.getElementById('final-tax').value = tax.toFixed(2);
            document.getElementById('final-shipping').value = shipping.toFixed(2);
            
            // Habilitar botón
            placeOrderBtn.disabled = false;
            locationWarning.style.display = 'none';
            
            console.log('Cálculo:', {
                subtotal: subtotalConDescuento,
                tax: tax,
                shipping: shipping,
                total: total
            });
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error calculating shipping costs. Please try again.');
            resetCosts();
        });
    }
    
    function updateTotals() {
        // Solo actualizar el total si no hay país seleccionado
        if (!countrySelect.value) {
            const newSubtotal = originalSubtotal - currentDiscount;
            document.getElementById('display-total').textContent = '$' + newSubtotal.toFixed(2);
        } else {
            // Recalcular con país seleccionado
            calculateCosts();
        }
    }
    
    function showDiscountLine() {
        if (appliedDiscountData) {
            discountLabel.textContent = `Additional Discount (${appliedDiscountData.codigo} - ${appliedDiscountData.porcentaje}%):`;
            discountAmount.textContent = '-$' + currentDiscount.toFixed(2);
            discountLine.style.display = 'flex';
        }
    }
    
    function removeDiscount() {
        currentDiscount = 0;
        appliedDiscountData = null;
        
        // Limpiar UI
        discountLine.style.display = 'none';
        discountStatus.style.display = 'none';
        removeDiscountBtn.style.display = 'none';
        applyDiscountBtn.style.display = 'block';
        discountCodeInput.disabled = false;
        discountCodeInput.value = '';
        
        // Limpiar campos ocultos
        document.getElementById('applied-discount-code').value = '';
        document.getElementById('applied-discount-amount').value = '';
        
        updateTotals();
    }
    
    function showDiscountMessage(message, type) {
        discountStatus.innerHTML = `
            <div class="alert alert-${type === 'success' ? 'success' : 'danger'} alert-sm mb-2">
                ${message}
                ${appliedDiscountData ? `<br><small>Applies to: ${appliedDiscountData.productos.join(', ')}</small>` : ''}
            </div>
        `;
        discountStatus.style.display = 'block';
    }
    
    function resetCosts() {
        document.getElementById('display-tax').textContent = '$0.00';
        document.getElementById('display-shipping').textContent = 'Select location';
        
        const subtotalConDescuento = originalSubtotal - currentDiscount;
        document.getElementById('display-total').textContent = '$' + subtotalConDescuento.toFixed(2);
        
        // Limpiar campos ocultos
        document.getElementById('final-country').value = '';
        document.getElementById('final-city').value = '';
        document.getElementById('final-total').value = '';
        document.getElementById('final-tax').value = '';
        document.getElementById('final-shipping').value = '';
        
        placeOrderBtn.disabled = true;
        locationWarning.style.display = 'block';
    }
    
    // Permitir aplicar descuento con Enter
    discountCodeInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            applyDiscountBtn.click();
        }
    });
});
</script>
@endsection