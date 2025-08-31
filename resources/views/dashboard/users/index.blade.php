@extends('layouts.app_admin')

@section('content')
<div class="container py-4" style="background-color:#011904; min-height:100vh;">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-white mb-0">👥 Users</h3>

    <form method="GET" class="d-flex gap-2">
      <input type="text" name="q" value="{{ $q }}" placeholder="Search name / email"
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
            <th class="text-white">Name</th>
            <th class="text-white">Email</th>
            <th class="text-white">Subscribed</th>
            <th class="text-white">Created</th>
            <th class="text-white">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $u)
          @php
            $sub = $u->newsletterSubscription;
            $isActive = $sub && is_null($sub->unsubscribed_at);
          @endphp
          <tr style="border-bottom:1px solid rgba(255,255,255,0.08);">
            <td class="text-white">{{ $u->name }}</td>
            <td class="text-white">{{ $u->email }}</td>
            <td>
              @if($sub)
                <span class="badge {{ $isActive ? 'bg-success' : 'bg-secondary' }}">
                  {{ $isActive ? 'Active' : 'Unsubscribed' }}
                </span>
              @else
                <span class="badge bg-light text-dark">No record</span>
              @endif
            </td>
            <td class="text-white">{{ $u->created_at->format('Y-m-d H:i') }}</td>
            <td>
              <form action="{{ route('admin.subscription.toggle', $u) }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-sm {{ $isActive ? 'btn-outline-warning' : 'btn-outline-success' }}">
                  {{ $isActive ? 'Deactivate' : 'Activate' }}
                </button>
              </form>

              <form action="{{ route('admin.user.delete', $u) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete user {{ $u->email }}? This cannot be undone.');">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">Delete</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center text-white-50 py-4">No users found</td>
          </tr>
          @endforelse
        </tbody>
      </table>

      <div class="mt-3">
        {{ $users->links() }}
      </div>
    </div>
  </div>
</div>
@endsection
