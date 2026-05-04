@extends('layouts.app')
@section('page-title', 'User Management')
@section('content')
<div class="card">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <span><i class="fa fa-users-cog me-2"></i>Staff Accounts</span>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" class="row g-2">
            <div class="col-md-4"><input type="text" name="search" class="form-control form-control-sm" placeholder="Search name..." value="{{ request('search') }}"></div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                    <option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option>
                    <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="role" class="form-select form-select-sm">
                    <option value="">All Roles</option>
                    <option value="pharmacist" {{ request('role')=='pharmacist'?'selected':'' }}>Pharmacist</option>
                    <option value="sales_clerk" {{ request('role')=='sales_clerk'?'selected':'' }}>Sales Clerk</option>
                </select>
            </div>
            <div class="col-md-2"><button class="btn btn-sm btn-success w-100">Filter</button></div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Registered</th><th>Actions</th></tr></thead>
                <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="fw-bold">
{{ $user->user_id_number_display }}
                        <br><small class="text-muted">{{ $user->name }}</small>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge bg-secondary">{{ ucfirst(str_replace('_',' ',$user->role)) }}</span></td>
                    <td>
                        @if($user->status === 'pending') <span class="badge badge-pending">Pending</span>
                        @elseif($user->status === 'active') <span class="badge badge-active">Active</span>
                        @else <span class="badge badge-inactive">Inactive</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        @if($user->status === 'pending')
                            <form method="POST" action="{{ route('admin.approve',$user) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success"><i class="fa fa-check"></i> Approve</button>
                            </form>
                            <form method="POST" action="{{ route('admin.reject',$user) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Reject</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.toggle',$user) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm {{ $user->status==='active'?'btn-warning':'btn-success' }}">{{ $user->status==='active'?'Deactivate':'Activate' }}</button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.users.destroy',$user) }}" class="d-inline" onsubmit="return confirm('Permanently delete user?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">No users found.</td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">{{ $users->withQueryString()->links() }}</div>
</div>
@endsection

