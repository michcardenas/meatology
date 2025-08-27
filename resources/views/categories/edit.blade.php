@extends('layouts.app_admin')

@section('content')
<div class="container py-5 text-white">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-warning mb-0">Edit Category 🐄</h2>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Categories
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="bg-dark p-4 rounded">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label text-light">Category Name</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $category->name) }}" placeholder="Enter category name">
        </div>

        <div class="mb-4">
            <label for="description" class="form-label fw-bold text-light">Description</label>
            <textarea name="description" id="description" rows="6" class="form-control bg-dark text-light border-secondary" placeholder="Enter category description">{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label text-light">Category Image</label>
            
            @if($category->image)
                <div class="mb-3">
                    <p class="text-muted mb-2">Current image:</p>
                    <img src="{{ Storage::url($category->image) }}" alt="Current image" style="width: 150px; height: 150px; object-fit: cover;" class="rounded border">
                </div>
            @endif
            
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
            <small class="text-muted">
                Accepted formats: JPG, PNG, GIF. Max size: 2MB. 
                @if($category->image)
                    Leave empty to keep current image.
                @endif
            </small>
        </div>

        <div class="d-flex gap-3">
            <button type="submit" class="btn btn-warning text-dark fw-bold" id="saveBtn">
                <i class="fas fa-save me-2"></i>Update Category
            </button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-times me-2"></i>Cancel
            </a>
        </div>
    </form>
</div>

<!-- 🔥 CKEDITOR SCRIPT -->
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

    // 🔥 INDICADOR DE PROGRESO AL ENVIAR
    document.querySelector('form').addEventListener('submit', function() {
        const btn = document.getElementById('saveBtn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating Category...';
        btn.disabled = true;
    });
</script>

<style>
/* Estilos para el formulario de edición */
.form-control {
    background-color: #2d3748;
    border: 1px solid #4a5568;
    color: #fff;
}

.form-control:focus {
    background-color: #2d3748;
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
    color: #fff;
}

.form-control::placeholder {
    color: #a0aec0;
}

.btn-warning {
    background-color: #ffc107;
    border-color: #ffc107;
    color: #000;
    font-weight: 600;
}

.btn-warning:hover {
    background-color: #e0a800;
    border-color: #d39e00;
    color: #000;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(255, 193, 7, 0.3);
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-secondary:hover {
    background-color: #5a6268;
    border-color: #545b62;
    transform: translateY(-2px);
}

.alert {
    border: none;
    border-radius: 10px;
}

/* Para la imagen actual */
.border {
    border: 2px solid #4a5568 !important;
}

/* 🔥 DARK MODE STYLES PARA CKEDITOR */
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
@endsection