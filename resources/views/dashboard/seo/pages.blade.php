{{-- resources/views/dashboard/seo/pages.blade.php --}}
@extends('layouts.app_admin')

@section('content')
<div class="container py-4" style="background-color:#011904; min-height:100vh;">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-white mb-0">🔎 Pages (SEO)</h3>
    <form method="GET" class="d-flex gap-2">
      <input type="text" name="q" value="{{ $q }}" placeholder="Search page/slug"
             class="form-control form-control-sm" style="max-width:240px;">
      <button class="btn btn-outline-light btn-sm">Search</button>
    </form>
  </div>

  <div class="card border-0 shadow" style="background: rgba(255,255,255,0.08);">
    <div class="card-body table-responsive">
      <table class="table table-borderless align-middle">
        <thead>
          <tr style="border-bottom:1px solid rgba(255,255,255,0.2);">
            <th class="text-white">ID</th>
            <th class="text-white">Page</th>
            <th class="text-white">Slug</th>
            <th class="text-white text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($paginas as $p)
            <tr style="border-bottom:1px solid rgba(255,255,255,0.08);">
              <td class="text-white">{{ $p->id }}</td>
              <td class="text-white">{{ $p->pagina }}</td>
              <td class="text-white"><code class="text-white-50">{{ $p->slug }}</code></td>
              <td class="text-end">
                <a href="{{ route('admin.seo.edit', $p) }}" class="btn btn-sm btn-light">
                  <i class="fas fa-search me-1"></i> SEO
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center text-white-50 py-4">No pages found</td>
            </tr>
          @endforelse
        </tbody>
      </table>

      <div class="mt-3">
        {{ $paginas->links() }}
      </div>
    </div>
  </div>
</div>
@endsection
