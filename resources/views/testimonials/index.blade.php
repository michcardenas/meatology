{{-- resources/views/testimonials/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Testimonios')

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="container py-5">
    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3 mb-4">
        <div>
            <h1 class="display-6 mb-1">Lo que dicen de nosotros</h1>
            <p class="text-muted mb-0">Testimonios más recientes primero.</p>
        </div>
        @if(isset($testimonios) && count($testimonios))
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                {{ method_exists($testimonios, 'total') ? $testimonios->total() : $testimonios->count() }} testimonios
            </span>
        @endif
    </div>

    {{-- Empty state --}}
    @if(!isset($testimonios) || !count($testimonios))
        <div class="text-center py-5">
            <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center"
                 style="width:84px;height:84px;background:rgba(13,110,253,.08);">
                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" fill="currentColor" class="text-primary" viewBox="0 0 16 16" aria-hidden="true">
                    <path d="M6.5 3.5c0-.828-.671-1.5-1.5-1.5H3C1.343 2 0 3.343 0 5v2c0 1.657 1.343 3 3 3h1a2 2 0 0 0 2-2V3.5zM16 3.5c0-.828-.671-1.5-1.5-1.5H12c-1.657 0-3 1.343-3 3v2c0 1.657 1.343 3 3 3h1a2 2 0 0 0 2-2V3.5z"/>
                </svg>
            </div>
            <h2 class="h5">Aún no hay testimonios</h2>
            <p class="text-muted">Cuando se registren, los verás aquí ordenados por fecha de creación.</p>
        </div>
    @else
        {{-- Tipografía para el contenido rico del testimonio --}}
        <style>
            .testimonial-rich * { margin: 0; }
            .testimonial-rich p { margin: .5rem 0; line-height: 1.6; }
            .testimonial-rich ul, .testimonial-rich ol { margin: .5rem 0 .5rem 1.25rem; }
            .testimonial-rich h1, .testimonial-rich h2, .testimonial-rich h3,
            .testimonial-rich h4, .testimonial-rich h5, .testimonial-rich h6 { margin: .5rem 0; }
            .testimonial-rich strong, .testimonial-rich b { font-weight: 600; }
            .testimonial-rich img { max-width: 100%; height: auto; border-radius: .5rem; }
            .testimonial-rich blockquote { padding-left: .75rem; border-left: 3px solid rgba(0,0,0,.1); color: #6c757d; }
        </style>

        {{-- Grid de tarjetas --}}
        <div class="row g-4">
            @foreach($testimonios as $t)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0">

                        {{-- Media (imagen o video) --}}
                        @php
                            $src = trim((string) ($t->imagen_video ?? '')); // p.ej. "testimonials/175762...png"
                            $displaySrc = null;
                            $isImage = false;
                            $isVideo = false;

                            if ($src) {
                                if (Str::startsWith($src, ['http://', 'https://', '//'])) {
                                    // URL absoluta
                                    $displaySrc = $src;
                                    $isImage = preg_match('/\.(jpe?g|png|webp|gif)$/i', $displaySrc);
                                    $isVideo = preg_match('/\.(mp4|webm|ogg)$/i', $displaySrc);
                                } else {
                                    // Ruta relativa en disk 'public'
                                    $exists = Storage::disk('public')->exists($src);
                                    if ($exists) {
                                        $displaySrc = Storage::url($src); // => /storage/...
                                        $isImage = preg_match('/\.(jpe?g|png|webp|gif)$/i', $src);
                                        $isVideo = preg_match('/\.(mp4|webm|ogg)$/i', $src);
                                    }
                                }
                            }
                        @endphp

                        @if($displaySrc && $isImage)
                            <img src="{{ $displaySrc }}"
                                 class="card-img-top object-fit-cover"
                                 style="height:180px"
                                 alt="Testimonio de {{ $t->nombre_usuario }}">
                        @elseif($displaySrc && $isVideo)
                            <div class="ratio ratio-16x9">
                                <video src="{{ $displaySrc }}" preload="metadata" class="rounded-top" controls></video>
                            </div>
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded-top"
                                 style="height:180px;">
                                {{-- Placeholder --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" fill="currentColor" class="text-secondary" viewBox="0 0 16 16" aria-hidden="true">
                                    <path d="M6.5 3.5c0-.828-.671-1.5-1.5-1.5H3C1.343 2 0 3.343 0 5v2c0 1.657 1.343 3 3 3h1a2 2 0 0 0 2-2V3.5zM16 3.5c0-.828-.671-1.5-1.5-1.5H12c-1.657 0-3 1.343-3 3v2c0 1.657 1.343 3 3 3h1a2 2 0 0 0 2-2V3.5z"/>
                                </svg>
                            </div>
                        @endif

                        {{-- Cuerpo --}}
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-inline-flex align-items-center justify-content-center me-2"
                                     style="width:40px;height:40px;">
                                    {{ mb_strtoupper(mb_substr($t->nombre_usuario ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <h5 class="card-title mb-0">{{ $t->nombre_usuario }}</h5>
                                    @if($t->created_at)
                                        <small class="text-muted">
                                            {{ $t->created_at->translatedFormat('d M Y') }}
                                            · {{ $t->created_at->diffForHumans() }}
                                        </small>
                                    @endif
                                </div>
                            </div>

                            {{-- Contenido del testimonio con HTML respetado --}}
                            <div class="testimonial-rich text-body">
                                {!! (string) $t->testimonios !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginación (si usas paginate() en el controlador) --}}
        @if(method_exists($testimonios, 'links'))
            <div class="d-flex justify-content-center mt-4">
                {{ $testimonios->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
