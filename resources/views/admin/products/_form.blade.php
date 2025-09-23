@csrf

<div class="mb-4">
    <label class="form-label fw-bold text-light">Product Name *</label>
    <input type="text" name="name" class="form-control bg-dark text-light border-secondary"
           value="{{ old('name', $product->name ?? '') }}" required>
</div>

<div class="mb-4">
  <label class="form-label fw-bold text-light">Description</label>
  <textarea id="description" name="description" rows="6" class="form-control bg-dark text-light border-secondary">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <label class="form-label fw-bold text-light">Stock *</label>
        <input type="number" name="stock" class="form-control bg-dark text-light border-secondary"
               value="{{ old('stock', $product->stock ?? 0) }}" required>
    </div>

    <div class="col-md-4 mb-4">
        <label class="form-label fw-bold text-light">Descripcion adicional (e.g. 7 Lbs or 3.2 Kg / Price)</label>
        <input type="text" name="avg_weight" class="form-control bg-dark text-light border-secondary"
               value="{{ old('avg_weight', $product->avg_weight ?? '') }}" placeholder="e.g. 7 Lbs or 3.2 Kg">
    </div>
</div>

<div class="mb-4">
    <label class="form-label fw-bold text-light">Product Images</label>
    
    <!-- 🔥 CAMBIO MÍNIMO: Solo agregué accept, onchange y un pequeño texto informativo -->
    <small class="text-muted d-block mb-2">Máximo 10 imágenes (JPG, PNG, WEBP)</small>
    <input type="file" 
           name="images[]" 
           class="form-control bg-dark text-light border-secondary" 
           multiple 
           accept="image/*"
           onchange="validateImages(this)">
    
    @if(isset($product) && $product->images && $product->images->count() > 0)
        <small class="text-muted d-block mt-2 mb-3">
            Currently has {{ $product->images->count() }} image{{ $product->images->count() > 1 ? 's' : '' }}
        </small>
        
        <!-- Grid de imágenes existentes -->
        <div class="row mt-3" id="images-container">
            @foreach($product->images as $image)
                <div class="col-md-3 col-sm-4 col-6 mb-3" id="image-{{ $image->id }}">
                    <div class="position-relative border border-secondary rounded p-2" style="background-color: #1a1a1a;">
                        <!-- Imagen -->
                        <img src="{{ Storage::url($image->image) }}" 
                             class="img-fluid rounded mb-2" 
                             style="height: 120px; width: 100%; object-fit: cover;" 
                             alt="Product image">
                        
                        <!-- Botón de eliminar -->
                        <button type="button" 
                                class="btn btn-danger btn-sm w-100 d-flex align-items-center justify-content-center gap-1"
                                onclick="deleteImageAjax({{ $image->id }})">
                            <span>🗑️</span> Delete
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- 🔥 NUEVA SECCIÓN: CERTIFICACIONES -->
<div class="mb-4">
    <label class="form-label fw-bold text-light">Certifications</label>
    
    <small class="text-muted d-block mb-2">Maximum 10 certification images (JPG, PNG, WEBP)</small>
    <input type="file" 
           name="certifications[]" 
           class="form-control bg-dark text-light border-secondary" 
           multiple 
           accept="image/*"
           onchange="validateCertifications(this)">
    
    @if(isset($product) && $product->certifications && $product->certifications->count() > 0)
        <small class="text-muted d-block mt-2 mb-3">
            Currently has {{ $product->certifications->count() }} certification{{ $product->certifications->count() > 1 ? 's' : '' }}
        </small>
        
        <!-- Grid de certificaciones existentes -->
        <div class="row mt-3" id="certifications-container">
            @foreach($product->certifications as $certification)
                <div class="col-md-3 col-sm-4 col-6 mb-3" id="certification-{{ $certification->id }}">
                    <div class="position-relative border border-secondary rounded p-2" style="background-color: #1a1a1a;">
                        <!-- Imagen de certificación -->
                        <img src="{{ Storage::url($certification->image) }}" 
                             class="img-fluid rounded mb-2" 
                             style="height: 120px; width: 100%; object-fit: cover;" 
                             alt="Certification image">
                        
                        <!-- Badge de certificación -->
                        <small class="badge bg-primary d-block mb-2">📜 Certification</small>
                        
                        <!-- Botón de eliminar -->
                        <button type="button" 
                                class="btn btn-danger btn-sm w-100 d-flex align-items-center justify-content-center gap-1"
                                onclick="deleteCertificationAjax({{ $certification->id }})">
                            <span>🗑️</span> Delete
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<div class="mb-4">
    <label class="form-label fw-bold text-light">Category *</label>
    <select name="category_id" class="form-select bg-dark text-light border-secondary" required>
        <option value="">-- Select a category --</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}"
                {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }} - {{ $cat->country }}
            </option>
        @endforeach
    </select>
</div>

{{-- SECCIÓN DE CERTIFICACIONES --}}
<div class="mb-4">
    <label class="form-label fw-bold text-light">Product Certifications</label>
    <div class="row mt-3">
        @for($i = 1; $i <= 3; $i++)
            <div class="col-md-4 mb-3">
                <div class="card bg-dark border-secondary h-100">
                    <div class="card-body text-center p-3">
                        <!-- Imagen de certificación -->
                        <div class="mb-3">
                            <img src="{{ asset('images/' . $i . '.webp') }}"
                                 alt="Certification {{ $i }}"
                                 class="img-fluid rounded"
                                 style="height: 80px; width: auto; max-width: 100%; object-fit: contain;">
                        </div>

                        <!-- Checkbox -->
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="certification[]"
                                   value="{{ $i }}"
                                   id="certification_{{ $i }}"
                                   {{ isset($product) && $product->certification && in_array($i, $product->certification) ? 'checked' : '' }}>
                            <label class="form-check-label text-light" for="certification_{{ $i }}">
                                Certification {{ $i }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>

    <!-- Botón para seleccionar/deseleccionar todas -->
    <div class="mt-3">
        <button type="button" class="btn btn-outline-light btn-sm" id="select-all-certifications">
            ✅ Select All
        </button>
        <button type="button" class="btn btn-outline-secondary btn-sm" id="deselect-all-certifications">
            ❌ Deselect All
        </button>
    </div>

    <small class="text-muted d-block mt-2">
        Select the certifications that apply to this product
    </small>
</div>

{{-- NUEVO CAMPO: País de Origen del Producto --}}
<div class="mb-4">
    <label class="form-label fw-bold text-light">Country of Origin *</label>
    <input type="text"
           name="pais"
           class="form-control bg-dark text-light border-secondary"
           value="{{ old('pais', $product->pais ?? '') }}"
           placeholder="Escribe el país de origen"
           required>
</div>

<div class="mb-4">
    <label class="form-label fw-bold text-light">Taxes by State</label>

    <div id="price-location-container">
        @if(isset($product) && $product->prices->count() > 0)
            @foreach($product->prices as $i => $price)
                <div class="row border rounded p-3 mb-3 bg-dark">
                    <div class="col-md-6 mb-2">
                        <label class="form-label text-light">State</label>
                        <select name="prices[{{ $i }}][country_id]" class="form-select bg-dark text-light">
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ $price->country_id == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-2">
                        <label class="form-label text-light">Tax (%)</label>
                        <input type="number" 
                               name="prices[{{ $i }}][interest]" 
                               class="form-control bg-dark text-light" 
                               value="{{ $price->interest ?? 0 }}"
                               step="0.01"
                               min="0" max="100"
                               placeholder="15.5">
                    </div>

                    <div class="col-md-2 mb-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm w-100" onclick="removePriceBlock(this)">
                            🗑️ Eliminar
                        </button>
                    </div>
                </div>
            @endforeach
        @else
            <div class="row border rounded p-3 mb-3 bg-dark">
                <div class="col-md-6 mb-2">
                    <label class="form-label text-light">State</label>
                    <select name="prices[0][country_id]" class="form-select bg-dark text-light">
                        <option value="">-- Select a state --</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-2">
                    <label class="form-label text-light">Tax (%)</label>
                    <input type="number" 
                           name="prices[0][interest]" 
                           class="form-control bg-dark text-light" 
                           value="0"
                           step="0.01"
                           min="0" max="100"
                           placeholder="15.5">
                </div>

                <div class="col-md-2 mb-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm w-100" onclick="removePriceBlock(this)">
                        🗑️ Eliminar
                    </button>
                </div>
            </div>
        @endif
    </div>

    <button type="button" class="btn btn-outline-light btn-sm" onclick="addPriceBlock()">
        ➕ Add tax by state
    </button>
</div>


{{-- Sección de Precio y Descuento --}}
<div class="row">
    <div class="col-md-6 mb-4">
        <label class="form-label fw-bold text-light">Precio Base *</label>
        <input type="number" name="price" step="0.01" class="form-control bg-dark text-light border-secondary"
               value="{{ old('price', $product->price ?? 0) }}" required>
        <small class="text-muted">Este es el precio base del producto</small>
    </div>

    <div class="col-md-6 mb-4">
        <label class="form-label fw-bold text-light">Descuento (%)</label>
        <input type="number" name="descuento" step="0.01" min="0" max="100" 
               class="form-control bg-dark text-light border-secondary"
               value="{{ old('descuento', $product->descuento ?? 0) }}"
               placeholder="ej: 15.50">
        <small class="text-muted">Porcentaje de descuento (0-100%)</small>
    </div>
</div>

<div class="d-flex justify-content-between mt-4">
    <button class="btn btn-success px-4" id="saveBtn">💾 Save Product</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create(document.querySelector('#description'), {
            toolbar: [
                'heading', '|',
                'bold','italic','underline','link','bulletedList','numberedList','blockQuote','undo','redo'
            ],
            link: { addTargetToExternalLinks: true },
            removePlugins: [
                'CKBox','CKFinder','EasyImage','ImageUpload','MediaEmbed','Table','TableToolbar'
            ]
        })
        .then(editor => {
            // Ajuste visual para dark mode
            const editable = editor.ui.getEditableElement();
            editable.style.backgroundColor = '#111';
            editable.style.color = '#e6e6e6';
            editable.style.minHeight = '180px';
            editable.style.border = '1px solid #444';
            editable.style.borderRadius = '6px';
        })
        .catch(console.error);

    let priceIndex = {{ isset($product) && $product->prices->count() > 0 ? $product->prices->count() : 1 }};
    const countries = @json($countries);

    // 🔥 FUNCIÓN SIMPLE DE VALIDACIÓN PARA IMÁGENES (EXISTENTE)
    function validateImages(input) {
        if (input.files.length > 10) {
            alert('❌ Maximum 10 images allowed');
            input.value = '';
            return;
        }
        
        // Mostrar feedback simple
        if (input.files.length > 0) {
            const saveBtn = document.getElementById('saveBtn');
            saveBtn.innerHTML = '📸 ' + input.files.length + ' image' + (input.files.length > 1 ? 's' : '') + ' selected - 💾 Save Product';
        }
    }

    // 🔥 NUEVA FUNCIÓN DE VALIDACIÓN PARA CERTIFICACIONES
    function validateCertifications(input) {
        if (input.files.length > 10) {
            alert('❌ Maximum 10 certifications allowed');
            input.value = '';
            return;
        }
        
        // Mostrar feedback simple
        if (input.files.length > 0) {
            const saveBtn = document.getElementById('saveBtn');
            const currentText = saveBtn.innerHTML;
            saveBtn.innerHTML = '📜 ' + input.files.length + ' certification' + (input.files.length > 1 ? 's' : '') + ' selected - 💾 Save Product';
        }
    }

    // 🔥 INDICADOR DE PROGRESO AL ENVIAR (EXISTENTE)
    document.querySelector('form').addEventListener('submit', function() {
        const btn = document.getElementById('saveBtn');
        btn.innerHTML = '⏳ Guardando producto...';
        btn.disabled = true;
    });

function addPriceBlock() {
        let block = `
            <div class="row border rounded p-3 mb-3 bg-dark">
                <div class="col-md-6 mb-2">
                    <label class="form-label text-light">State</label>
                    <select name="prices[\${priceIndex}][country_id]" class="form-select bg-dark text-light">
                        <option value="">-- Select a state --</option>
                        ${countries.map(c => `<option value="${c.id}">${c.name}</option>`).join('')}
                    </select>
                </div>

                <div class="col-md-4 mb-2">
                    <label class="form-label text-light">Tax (%)</label>
                    <input type="number" 
                           name="prices[\${priceIndex}][interest]" 
                           class="form-control bg-dark text-light" 
                           value="0"
                           step="0.01"
                           min="0" max="100"
                           placeholder="15.5">
                </div>

                <div class="col-md-2 mb-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm w-100" onclick="removePriceBlock(this)">
                        🗑️ Eliminar
                    </button>
                </div>
            </div>
        `;
        document.getElementById('price-location-container').insertAdjacentHTML('beforeend', block);
        priceIndex++;
    }

    function removePriceBlock(button) {
        button.closest('.row').remove();
    }
    
    function loadCities(select) {
        const countryId = parseInt(select.value);
        const cities = countries.find(c => c.id === countryId)?.cities || [];
        const citySelect = select.parentElement.nextElementSibling.querySelector('select');

        citySelect.innerHTML = `<option value="">-- Selecciona ciudad --</option>`;
        citySelect.innerHTML += cities.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
    }

    function removePriceBlock(button) {
        button.closest('.row').remove();
    }

    // 🔥 FUNCIÓN PARA ELIMINAR CERTIFICACIONES (si la necesitas después)
    function deleteCertificationAjax(certificationId) {
        if (confirm('Are you sure you want to delete this certification?')) {
            // Aquí irá tu lógica AJAX para eliminar la certificación
            console.log('Deleting certification:', certificationId);
        }
    }

    // 📋 FUNCIONES PARA MANEJAR CERTIFICACIONES
    document.getElementById('select-all-certifications').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('input[name="certification[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
        updateCertificationStatus();
    });

    document.getElementById('deselect-all-certifications').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('input[name="certification[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        updateCertificationStatus();
    });

    // Función para actualizar el estado visual
    function updateCertificationStatus() {
        const checkboxes = document.querySelectorAll('input[name="certification[]"]');
        const checkedCount = document.querySelectorAll('input[name="certification[]"]:checked').length;

        if (checkedCount === checkboxes.length) {
            console.log('All certifications selected');
        } else if (checkedCount === 0) {
            console.log('No certifications selected');
        } else {
            console.log(`${checkedCount} of ${checkboxes.length} certifications selected`);
        }
    }

    // Agregar event listeners a los checkboxes individuales
    document.querySelectorAll('input[name="certification[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', updateCertificationStatus);
    });
</script>

<style>
/* Dark mode amigable dentro del editor */
.ck-content {
  background: #111 !important;
  color: #e6e6e6 !important;
}
.ck.ck-editor__main>.ck-editor__editable {
  border-color: #444 !important;
}
.ck.ck-toolbar {
  background: #121212 !important;
  border-color: #444 !important;
}
.ck.ck-button, .ck.ck-toolbar__separator {
  filter: brightness(0.9);
}
</style>