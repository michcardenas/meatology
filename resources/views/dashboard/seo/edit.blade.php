@extends('layouts.app_admin')

@section('content')
@php
  /** @var \App\Models\Pagina $pagina */
  $seo = $pagina->seo; // puede ser null si aún no existe
@endphp

<div class="container py-4" style="background-color:#011904; min-height:100vh;">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-white mb-0">🔧 SEO: {{ $pagina->pagina }}</h3>
    <a href="{{ route('admin.seo.pages') }}" class="btn btn-outline-light btn-sm">Back to list</a>
  </div>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <strong>Revisa los campos:</strong>
      <ul class="mb-0">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card border-0 shadow" style="background:rgba(255,255,255,0.08);">
    <div class="card-body">
      <form method="POST" action="{{ route('admin.seo.update', $pagina) }}">
        @csrf
        @method('PUT')

        {{-- META BÁSICOS --}}
        <h5 class="text-white">Meta tags</h5>
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label class="form-label text-white">Meta Title <small class="text-white-50">(≤ 70)</small></label>
            <input type="text" name="meta_title" maxlength="70"
                   value="{{ old('meta_title', $seo->meta_title ?? $pagina->pagina) }}"
                   class="form-control">
            <small class="text-white-50 char-counter" data-for="meta_title"></small>
          </div>

          <div class="col-md-6">
            <label class="form-label text-white">Meta Keywords <small class="text-white-50">(opcional, separa por coma)</small></label>
            <input type="text" name="meta_keywords"
                   value="{{ old('meta_keywords', $seo->meta_keywords ?? '') }}"
                   class="form-control">
          </div>

          <div class="col-12">
            <label class="form-label text-white">Meta Description <small class="text-white-50">(≤ 160)</small></label>
            <textarea name="meta_description" maxlength="160" rows="2" class="form-control">{{ old('meta_description', $seo->meta_description ?? '') }}</textarea>
            <small class="text-white-50 char-counter" data-for="meta_description"></small>
          </div>

          <div class="col-md-6">
            <label class="form-label text-white">Canonical URL</label>
            <input type="url" name="canonical_url"
                   value="{{ old('canonical_url', $seo->canonical_url ?? '') }}"
                   class="form-control" placeholder="https://meatology.us/{{ $pagina->slug }}">
          </div>

          <div class="col-md-6">
            <label class="form-label text-white">Robots</label>
            @php
              $robotsVal = old('robots', $seo->robots ?? 'index,follow');
            @endphp
            <select name="robots" class="form-select">
              <option value="index,follow"     {{ $robotsVal==='index,follow' ? 'selected' : '' }}>index,follow</option>
              <option value="noindex,follow"   {{ $robotsVal==='noindex,follow' ? 'selected' : '' }}>noindex,follow</option>
              <option value="index,nofollow"   {{ $robotsVal==='index,nofollow' ? 'selected' : '' }}>index,nofollow</option>
              <option value="noindex,nofollow" {{ $robotsVal==='noindex,nofollow' ? 'selected' : '' }}>noindex,nofollow</option>
            </select>
          </div>
        </div>

        <hr class="border-light opacity-25">

        {{-- OPEN GRAPH --}}
        <h5 class="text-white">Open Graph</h5>
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label class="form-label text-white">OG Title <small class="text-white-50">(≤ 95)</small></label>
            <input type="text" name="og_title" maxlength="95"
                   value="{{ old('og_title', $seo->og_title ?? $pagina->pagina) }}"
                   class="form-control">
            <small class="text-white-50 char-counter" data-for="og_title"></small>
          </div>
          <div class="col-md-6">
            <label class="form-label text-white">OG Type</label>
            @php $ogType = old('og_type', $seo->og_type ?? 'website'); @endphp
            <select name="og_type" class="form-select">
              <option value="website" {{ $ogType==='website' ? 'selected' : '' }}>website</option>
              <option value="article" {{ $ogType==='article' ? 'selected' : '' }}>article</option>
              <option value="product" {{ $ogType==='product' ? 'selected' : '' }}>product</option>
            </select>
          </div>

          <div class="col-12">
            <label class="form-label text-white">OG Description</label>
            <textarea name="og_description" rows="2" class="form-control">{{ old('og_description', $seo->og_description ?? ($seo->meta_description ?? '')) }}</textarea>
          </div>

          <div class="col-md-8">
            <label class="form-label text-white">OG Image (URL)</label>
            <input type="text" name="og_image"
                   value="{{ old('og_image', $seo->og_image ?? '') }}"
                   class="form-control" placeholder="https://.../image.jpg">
          </div>

          <div class="col-md-4">
            <label class="form-label text-white">OG Locale</label>
            <input type="text" name="og_locale"
                   value="{{ old('og_locale', $seo->og_locale ?? 'en_US') }}"
                   class="form-control" placeholder="en_US">
          </div>
        </div>

        <hr class="border-light opacity-25">

        {{-- TWITTER --}}
        <h5 class="text-white">Twitter Cards</h5>
        <div class="row g-3 mb-4">
          <div class="col-md-4">
            <label class="form-label text-white">Card Type</label>
            @php $tw = old('twitter_card', $seo->twitter_card ?? 'summary_large_image'); @endphp
            <select name="twitter_card" class="form-select">
              <option value="summary_large_image" {{ $tw==='summary_large_image' ? 'selected' : '' }}>summary_large_image</option>
              <option value="summary" {{ $tw==='summary' ? 'selected' : '' }}>summary</option>
              <option value="app" {{ $tw==='app' ? 'selected' : '' }}>app</option>
              <option value="player" {{ $tw==='player' ? 'selected' : '' }}>player</option>
            </select>
          </div>

          <div class="col-md-4">
            <label class="form-label text-white">Twitter Title</label>
            <input type="text" name="twitter_title"
                   value="{{ old('twitter_title', $seo->twitter_title ?? ($seo->meta_title ?? $pagina->pagina)) }}"
                   class="form-control">
          </div>

          <div class="col-md-4">
            <label class="form-label text-white">Twitter Image (URL)</label>
            <input type="text" name="twitter_image"
                   value="{{ old('twitter_image', $seo->twitter_image ?? ($seo->og_image ?? '')) }}"
                   class="form-control" placeholder="https://.../image.jpg">
          </div>

          <div class="col-12">
            <label class="form-label text-white">Twitter Description</label>
            <textarea name="twitter_description" rows="2" class="form-control">{{ old('twitter_description', $seo->twitter_description ?? ($seo->meta_description ?? '')) }}</textarea>
          </div>
        </div>

        <hr class="border-light opacity-25">

        {{-- JSON-LD --}}
        <h5 class="text-white">JSON-LD (schema.org)</h5>
        <div class="mb-4">
          <textarea name="json_ld" rows="6" class="form-control" placeholder='{"@context":"https://schema.org","@type":"WebPage"}'>{{ old('json_ld', !empty($seo?->json_ld) ? json_encode($seo->json_ld, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) : '') }}</textarea>
          <small class="text-white-50">Pega aquí JSON válido. Se almacenará como objeto.</small>
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-success">
            <i class="fas fa-save me-1"></i> Guardar SEO
          </button>
          <a href="{{ route('admin.seo.pages') }}" class="btn btn-outline-light">Cancelar</a>
        </div>

      </form>
    </div>
  </div>
</div>

{{-- Simple contador de caracteres para inputs/areas con maxlength --}}
<script>
  (function() {
    const counters = document.querySelectorAll('.char-counter');
    counters.forEach(function(c) {
      const name = c.getAttribute('data-for');
      const el = document.querySelector(`[name="${name}"]`);
      if (!el) return;
      const max = el.getAttribute('maxlength') || 0;
      const update = () => {
        c.textContent = max ? `${el.value.length}/${max}` : `${el.value.length}`;
      };
      el.addEventListener('input', update);
      update();
    });
  })();
</script>
@endsection
