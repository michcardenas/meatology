@extends('layouts.app_admin')

@section('content')
<div class="container py-4" style="background-color: #011904; min-height: 100vh;">
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="text-white" style="color: white !important;">💬 Manage Testimonials</h2>
                <p class="text-white" style="color: rgba(255,255,255,0.8) !important;">
                    View and manage customer testimonials
                </p>
            </div>
            <button type="button" class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#createTestimonialModal">
                <i class="fas fa-plus me-2"></i>Add New Testimonial
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: rgba(255,255,255,0.1);">
                    <h4 class="text-white mb-0" style="color: white !important;">
                        <i class="fas fa-quote-left me-2"></i>Testimonials List
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(isset($testimonials) && $testimonials->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr style="border-bottom: 2px solid rgba(255,255,255,0.2);">
                                        <th class="text-white fw-bold" style="color: white !important;">User</th>
                                        <th class="text-white fw-bold" style="color: white !important;">Email</th>
                                        <th class="text-white fw-bold" style="color: white !important;">Testimonial</th>
                                        <th class="text-white fw-bold" style="color: white !important;">Media</th>
                                        <th class="text-white fw-bold" style="color: white !important;">Date</th>
                                        <th class="text-white fw-bold" style="color: white !important;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($testimonials as $testimonial)
                                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                                            <td class="text-white py-3" style="color: white !important;">
                                                <strong>{{ $testimonial->nombre_usuario }}</strong>
                                            </td>
                                            <td class="text-white py-3" style="color: white !important;">
                                                {{ $testimonial->correo }}
                                            </td>
                                            <td class="text-white py-3" style="color: white !important;">
                                                <div style="max-width: 300px;">
                                                    {{ \Illuminate\Support\Str::limit($testimonial->testimonios, 100) }}
                                                </div>
                                            </td>
                                            <td class="text-white py-3" style="color: white !important;">
                                                @if($testimonial->imagen_video)
                                                    @if(str_contains($testimonial->imagen_video, '.mp4') || str_contains($testimonial->imagen_video, '.mov'))
                                                        <span class="badge bg-info">
                                                            <i class="fas fa-video me-1"></i>Video
                                                        </span>
                                                    @else
                                                        <span class="badge bg-primary">
                                                            <i class="fas fa-image me-1"></i>Image
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">No media</span>
                                                @endif
                                            </td>
                                            <td class="text-white py-3" style="color: white !important;">
                                                {{ $testimonial->created_at->format('M d, Y') }}
                                                <br>
                                                <small class="text-white-50" style="color: rgba(255,255,255,0.7) !important;">
                                                    {{ $testimonial->created_at->format('g:i A') }}
                                                </small>
                                            </td>
                                            <td class="py-3">
                                                <button class="btn btn-outline-warning btn-sm me-1" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editTestimonialModal"
                                                        onclick="editTestimonial({{ $testimonial->id }})"
                                                        style="color: white !important; border-color: #ffc107;">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm" 
                                                        onclick="deleteTestimonial({{ $testimonial->id }})"
                                                        style="color: white !important; border-color: #dc3545;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        @if($testimonials->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $testimonials->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-quote-left fa-3x text-white mb-3" style="color: rgba(255,255,255,0.5) !important;"></i>
                            <h5 class="text-white" style="color: white !important;">No testimonials found</h5>
                            <p class="text-white-50" style="color: rgba(255,255,255,0.7) !important;">
                                Add your first testimonial to get started.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Crear Testimonio -->
<div class="modal fade" id="createTestimonialModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #011904; border: 1px solid rgba(255,255,255,0.2);">
            <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.2);">
                <h5 class="modal-title text-white">Add New Testimonial</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-white">User Name</label>
                        <input type="text" name="nombre_usuario" class="form-control" required 
                               style="background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.3);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white">Email</label>
                        <input type="email" name="correo" class="form-control" required
                               style="background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.3);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white">Testimonial</label>
                        <textarea name="testimonios" class="form-control" rows="4" required
                                  style="background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.3);"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white">Image or Video (Optional)</label>
                        <input type="file" name="imagen_video" class="form-control" accept="image/*,video/*"
                               style="background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.3);">
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.2);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Create Testimonial</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Editar Testimonio -->
<div class="modal fade" id="editTestimonialModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #011904; border: 1px solid rgba(255,255,255,0.2);">
            <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.2);">
                <h5 class="modal-title text-white">Edit Testimonial</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editTestimonialForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-white">User Name</label>
                        <input type="text" name="nombre_usuario" id="edit_nombre_usuario" class="form-control" required 
                               style="background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.3);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white">Email</label>
                        <input type="email" name="correo" id="edit_correo" class="form-control" required
                               style="background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.3);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white">Testimonial</label>
                        <textarea name="testimonios" id="edit_testimonios" class="form-control" rows="4" required
                                  style="background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.3);"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white">Image or Video (Optional)</label>
                        <input type="file" name="imagen_video" class="form-control" accept="image/*,video/*"
                               style="background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.3);">
                        <small class="text-muted">Leave empty to keep current file</small>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.2);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Update Testimonial</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Estilos para mantener consistencia */
.container,
.container *,
.card,
.card *,
.table,
.table *,
h1, h2, h3, h4, h5, h6,
p, span, div, small, strong, b,
th, td {
    color: white !important;
}

.form-control:focus {
    border-color: rgba(255,255,255,0.5) !important;
    box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25) !important;
}

.table tbody tr:hover {
    background-color: rgba(255,255,255,0.05) !important;
}

.btn:hover {
    transform: translateY(-1px);
}
</style>

<!-- Quill.js CSS y JS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
// Variables globales para los editores Quill
let createQuill;
let editQuill;

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar Quill para crear testimonio
    createQuill = new Quill('#create_testimonios_editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['blockquote'],
                ['clean']
            ]
        },
        placeholder: 'Write the testimonial here...'
    });

    // Inicializar Quill para editar testimonio
    editQuill = new Quill('#edit_testimonios_editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['blockquote'],
                ['clean']
            ]
        },
        placeholder: 'Edit the testimonial here...'
    });

    // Función para editar testimonio
    window.editTestimonial = function(id) {
        fetch(`/admin/testimonials/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('edit_nombre_usuario').value = data.nombre_usuario;
                document.getElementById('edit_correo').value = data.correo;
                
                // Setear contenido en Quill editor
                editQuill.root.innerHTML = data.testimonios;
                
                document.getElementById('editTestimonialForm').action = `/admin/testimonials/${id}`;
            })
            .catch(error => console.error('Error:', error));
    };

    // Función para eliminar testimonio
    window.deleteTestimonial = function(id) {
        if (confirm('Are you sure you want to delete this testimonial?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/testimonials/${id}`;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    };

    // Sincronizar contenido de Quill con campos hidden antes de enviar formularios
    document.getElementById('createTestimonialModal').querySelector('form').addEventListener('submit', function() {
        document.getElementById('create_testimonios_hidden').value = createQuill.root.innerHTML;
    });

    document.getElementById('editTestimonialForm').addEventListener('submit', function() {
        document.getElementById('edit_testimonios_hidden').value = editQuill.root.innerHTML;
    });

    // Limpiar editor al cerrar modal de crear
    const createModal = document.getElementById('createTestimonialModal');
    createModal.addEventListener('hidden.bs.modal', function () {
        createQuill.setContents([]);
    });
});
</script>
</script>

@endsection