<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmastream</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --sidebar-width: 250px; --primary: #0ba8ff; --primary-dark: #c687ff; --primary-light: #e0c8ff; }
        body { background: url('https://img.freepik.com/premium-photo/pharmacy-interior-design-creating-modern-shop-environment_1152821-1799.jpg?w=2000') center/cover no-repeat; font-family: 'Segoe UI', sans-serif; min-height: 100vh; position: relative; color: white; }
        body::before { content: ''; position: fixed; inset: 0; background: rgba(0,0,0,0.6); pointer-events: none; z-index: 0; }
        .sidebar { width: var(--sidebar-width); background: rgba(11,168,255,0.85); backdrop-filter: blur(10px); min-height: 100vh; position: fixed; top: 0; left: 0; z-index: 100; border-right: 1px solid rgba(255,255,255,0.2); }
        .sidebar-brand { padding: 1.5rem; color: white; font-size: 1.2rem; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.2); }
        .sidebar-brand span { color: var(--primary-light); }
        .sidebar .nav-link { color: rgba(255,255,255,0.9); padding: .6rem 1.5rem; display: flex; align-items: center; gap: 10px; transition: all .2s; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background: rgba(255,255,255,0.2); }
        .sidebar .nav-link i { width: 20px; text-align: center; }
        .sidebar-section { font-size: .7rem; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,.6); padding: .5rem 1.5rem; margin-top: .5rem; }
        .main-content { margin-left: var(--sidebar-width); padding: 0; position: relative; z-index: 1; min-height: 100vh; }
        .topbar { background: rgba(255,255,255,0.1); backdrop-filter: blur(8px); border-bottom: 1px solid rgba(255,255,255,0.2); padding: .8rem 1.5rem; display: flex; align-items: center; justify-content: space-between; }
        .topbar h6 { color: rgba(255,255,255,0.8) !important; }
        .page-content { padding: 1.5rem; }

        .card { border: 1px solid rgba(255,255,255,0.15); border-radius: 16px; background: rgba(255,255,255,0.06); backdrop-filter: blur(12px); color: white; }
        .card-header { background: rgba(255,255,255,0.08); border-bottom: 1px solid rgba(255,255,255,0.15); font-weight: 600; color: white; }
        .card-footer { background: rgba(255,255,255,0.08); border-top: 1px solid rgba(255,255,255,0.15); }
        .card-body { background: transparent !important; }

        .form-control, .form-select { background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.2); color: white; border-radius: 8px; }
        .form-control::placeholder { color: rgba(255,255,255,0.45); }
        .form-control:focus, .form-select:focus { background: rgba(255,255,255,0.15); border-color: rgba(255,255,255,0.5); color: white; box-shadow: 0 0 0 0.25rem rgba(255,255,255,0.15); }
        .form-control.is-invalid, .form-select.is-invalid { background: rgba(255,255,255,0.08); border-color: rgba(220,53,69,0.6); background-image: none; }
        .form-control.is-invalid:focus, .form-select.is-invalid:focus { background: rgba(255,255,255,0.15); box-shadow: 0 0 0 0.25rem rgba(220,53,69,0.25); }
        .invalid-feedback { color: #ff9aa2; }
        .form-select option { background: #333; color: white; }
        .form-label, label { color: rgba(255,255,255,0.85); font-weight: 500; }
        .input-group-text { background: rgba(255,255,255,0.12); border-color: rgba(255,255,255,0.2); color: white; }
        .form-check-input { background-color: rgba(255,255,255,0.15); border-color: rgba(255,255,255,0.4); }
        .form-check-input:checked { background-color: white; border-color: white; }
        .text-danger { color: #ff9aa2 !important; }
        .text-success { color: #a8e6cf !important; }

        .btn-primary { background: transparent; border: 2px solid white; color: white; }
        .btn-primary:hover { background: white; border-color: white; color: #0ba8ff; }
        .btn-outline-primary { border: 2px solid white; color: white; }
        .btn-outline-primary:hover { background: white; color: #0ba8ff; }
        .btn-outline-secondary { border: 1px solid rgba(255,255,255,0.4); color: rgba(255,255,255,0.8); }
        .btn-outline-secondary:hover { background: rgba(255,255,255,0.15); color: white; }

        .table { --bs-table-bg: transparent !important; --bs-table-color: white; color: white; margin-bottom: 0; }
        .table thead th { background: rgba(255,255,255,0.1) !important; font-size: .85rem; text-transform: uppercase; letter-spacing: .5px; color: rgba(255,255,255,0.75); border-bottom: 1px solid rgba(255,255,255,0.15) !important; font-weight: 600; padding: .75rem 1rem; }
        .table tbody td { background: transparent !important; color: white; border-bottom: 1px solid rgba(255,255,255,0.08) !important; padding: .75rem 1rem; vertical-align: middle; }
        .table tbody tr:hover td { background: rgba(255,255,255,0.06) !important; }
        .table tbody tr:last-child td { border-bottom: none !important; }
        .table-responsive { border-radius: 0 0 12px 12px; }

        .list-group-item { background: rgba(255,255,255,0.06); border-color: rgba(255,255,255,0.1); color: white; }
        .list-group-item:hover { background: rgba(255,255,255,0.1); }

        .pagination .page-link { background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: white; }
        .pagination .page-link:hover { background: rgba(255,255,255,0.15); color: white; }
        .pagination .active .page-link { background: white; border-color: white; color: #0ba8ff; }

        .badge-pending { background: rgba(255,193,7,0.25); color: #ffe066; }
        .badge-active { background: rgba(23,162,184,0.25); color: #a5e9f7; }
        .badge-inactive { background: rgba(220,53,69,0.25); color: #f5a3ad; }
        .badge { font-weight: 500; }

        .text-muted { color: rgba(255,255,255,0.6) !important; }
        .text-dark { color: white !important; }
        h1, h2, h3, h4, h5, h6 { color: white; }
        a { color: var(--primary-light); }
        a:hover { color: white; }

        .alert { border-radius: 10px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: white; }
        .alert-success { background: rgba(40,167,69,0.12); border-color: rgba(40,167,69,0.3); }
        .alert-danger { background: rgba(220,53,69,0.12); border-color: rgba(220,53,69,0.3); }

        .modal-content { background: rgba(20,20,20,0.95); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.15); color: white; }
        .modal-header, .modal-footer { border-color: rgba(255,255,255,0.15); }

        .stat-card { border-radius: 12px; padding: 1.2rem; color: white; backdrop-filter: blur(6px); border: 1px solid rgba(255,255,255,0.15); background: rgba(255,255,255,0.05); }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand"><i class="fa fa-capsules me-2"></i>Pharma<span>stream</span></div>
    <nav class="mt-2">
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fa fa-tachometer-alt"></i> Dashboard
        </a>
        @if(auth()->user()->isAdmin())
        <div class="sidebar-section">Administration</div>
        <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
            <i class="fa fa-users-cog"></i> User Management
        </a>
        <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <i class="fa fa-tags"></i> Categories
        </a>
        <a href="{{ route('suppliers.index') }}" class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
            <i class="fa fa-truck"></i> Suppliers
        </a>
        @endif
        @if(auth()->user()->isAdmin() || auth()->user()->isPharmacist())
        <div class="sidebar-section">Inventory</div>
        <a href="{{ route('medicines.index') }}" class="nav-link {{ request()->routeIs('medicines.*') ? 'active' : '' }}">
            <i class="fa fa-pills"></i> Medicines
        </a>
        <a href="{{ route('batches.index') }}" class="nav-link {{ request()->routeIs('batches.*') ? 'active' : '' }}">
            <i class="fa fa-boxes"></i> Batches &amp; Expiry
        </a>
        <a href="{{ route('prescriptions.index') }}" class="nav-link {{ request()->routeIs('prescriptions.*') ? 'active' : '' }}">
            <i class="fa fa-file-medical"></i> Prescriptions
        </a>
        @endif
        @if(auth()->user()->isAdmin() || auth()->user()->isSalesClerk())
        <div class="sidebar-section">Sales</div>
        <a href="{{ route('sales.index') }}" class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}">
            <i class="fa fa-cash-register"></i> Sales / POS
        </a>
        @endif
    </nav>
</div>

<div class="main-content">
    <div class="topbar">
        <h6 class="mb-0">@yield('page-title', 'Dashboard')</h6>
        <div class="d-flex align-items-center gap-3">
            <span class="badge" style="background:rgba(255,255,255,0.15);color:white;border:1px solid rgba(255,255,255,0.25);">
                <i class="fa fa-user me-1"></i>{{ auth()->user()->name }} ({{ ucfirst(str_replace('_',' ',auth()->user()->role)) }})
            </span>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button class="btn btn-sm btn-outline-secondary"><i class="fa fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </div>
    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show"><i class="fa fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif
        @yield('content')
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>

