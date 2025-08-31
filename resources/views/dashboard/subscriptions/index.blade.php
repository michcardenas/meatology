@extends('layouts.app_admin')

@section('content')
<div class="container py-4" style="background-color:#011904; min-height:100vh;">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-white mb-0">📧 Subscribers</h3>

    <form method="GET" class="d-flex gap-2">
      <input type="text" name="q" value="{{ $q }}" placeholder="Search email / user"
             class="form-control form-control-sm" style="max-width:240px;">
      <button class="btn btn-outline-light btn-sm">Search</button>
    </form>
  </div>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <div class="card border-0 shadow" style="background: rgba(255,255,255,0.08);">
    <div class="card-body table-responsive">
      <table class="table table-borderless align-middle">
        <thead>
          <tr style="border-bottom:1px solid rgba(255,255,255,0.2);">
            <th class="text-white">Email</th>
            <th class="text-white">User</th>
            <th class="text-white">Status</th>
            <th class="text-white">Subscribed</th>
            <th class="text-white">Updated</th>
          </tr>
        </thead>
        <tbody>
          @forelse($subs as $s)
          @php
            $active = is_null($s->unsubscribed_at);
          @endphp
          <tr style="border-bottom:1px solid rgba(255,255,255,0.08);">
            <td class="text-white">{{ $s->email }}</td>
            <td class="text-white">
              @if($s->user)
                {{ $s->user->name }}
                <small class="text-white-50">({{ $s->user->email }})</small>
              @else
                <span class="text-white-50">Guest</span>
              @endif
            </td>
            <td>
              <span class="badge {{ $active ? 'bg-success' : 'bg-secondary' }}">
                {{ $active ? 'Active' : 'Unsubscribed' }}
              </span>
              @if($s->confirmed)
                <span class="badge bg-info ms-1">Confirmed</span>
              @else
                <span class="badge bg-warning text-dark ms-1">Pending</span>
              @endif
            </td>
            <td class="text-white">{{ optional($s->subscribed_at)->format('Y-m-d H:i') ?? '—' }}</td>
            <td class="text-white">{{ $s->updated_at->format('Y-m-d H:i') }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center text-white-50 py-4">No subscribers</td>
          </tr>
          @endforelse
        </tbody>
      </table>

      <div class="mt-3">
        {{ $subs->links() }}
      </div>
    </div>
  </div>
</div>
@endsection
