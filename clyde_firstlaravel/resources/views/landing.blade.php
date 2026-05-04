<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmastream - Pharmacy Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --blue: #080808; --blue-light: #e0c8ff; --blue-dark: #c687ff; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f8faff; font-family: 'Segoe UI', sans-serif; }
        nav { background: white; padding: 1rem 2rem; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 10px rgba(0,0,0,.06); position: sticky; top: 0; z-index: 999; }
        .brand { font-size: 1.5rem; font-weight: 800; color: var(--blue); }
        .brand span { color: #aaa; }
        .nav-btns .btn { margin-left: .5rem; }
        .hero { background: url('https://img.freepik.com/premium-photo/pharmacist-is-seen-utilizing-digital-tablet-conduct-inventory-management-tasks-within-pharmacy-setting_686498-8600.jpg') center/cover no-repeat; min-height: 90vh; display: flex; align-items: center; color: white; position: relative; overflow: hidden; }
        .hero::before { content: ''; position: absolute; inset: 0; background: rgba(0,0,0,0.55); pointer-events: none; z-index: 0; }
        .hero-text { position: relative; z-index: 1; text-align: center; }
        .hero-text h1 { font-size: 3.5rem; font-weight: 800; line-height: 1.1; margin-bottom: 1rem; }
        .hero-text h1 span { color: var(--blue-light); }
        .hero-text p { font-size: 1.2rem; opacity: .85; margin-bottom: 2rem; }
        .hero-btns .btn { padding: .8rem 2rem; border-radius: 50px; font-weight: 600; margin-right: .5rem; }
        .btn-white { background: white; color: var(--blue); }
        .btn-white:hover { background: #090909; color: var(--blue); }
        .btn-outline-white { border: 2px solid white; color: white; }
        .btn-outline-white:hover { background: white; color: var(--blue); }
        .features { padding: 5rem 0; background: #0ba8ff; }
        .feature-card { background: #89ccf1; border-radius: 16px; padding: 2rem; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,.06); height: 100%; transition: transform .3s; }
        .feature-card:hover { transform: translateY(-5px); }
        .feature-icon { width: 70px; height: 70px; border-radius: 20px; background: white; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 2rem; color: #0f0f0f; }
        .feature-card h5 { font-weight: 700; margin-bottom: .5rem; color: white; }
        .feature-card p { color: white; font-size: .9rem; }
        .roles-section { padding: 5rem 0; background: white; }
        .role-card { border: 2px solid #29066a; border-radius: 16px; padding: 1.5rem; text-align: center; transition: all .3s; }
        .role-card:hover { border-color: var(--blue); background: #5583d3; }
        .role-icon { font-size: 2.5rem; color: var(--blue); margin-bottom: 1rem; }
        footer { background: #0ba8ff; color: rgba(255,255,255,.9); text-align: center; padding: 2rem; }
        footer strong { color: white; }
    </style>
</head>
<body>
<nav>
    <div class="brand"><i class="fa fa-capsules me-2"></i>Pharma<span>stream</span></div>
    <div class="nav-btns">
        <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
        <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
    </div>
</nav>

<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-text">
                <h1><span>Pharmastream</span> Management System</h1>
                <p>Streamline your pharmacy operations with our all-in-one system. Manage inventory, sales, prescriptions, and staff &mdash; all in one place.</p>
                <div class="hero-btns">
                    <a href="{{ route('login') }}" class="btn btn-outline-white">Get Started</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-white">Create Account</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="features">
    <div class="container">
        <p class="text-center mb-5" style="color:white;">Powerful modules to run your pharmacy efficiently</p>
        <div class="row g-4">
            <div class="col-md-4"><div class="feature-card"><div class="feature-icon"><i class="fa fa-boxes"></i></div><h5>Inventory Management</h5><p>Track medicine stock levels, categories, and get low-stock alerts instantly.</p></div></div>
            <div class="col-md-4"><div class="feature-card"><div class="feature-icon"><i class="fa fa-cash-register"></i></div><h5>Point of Sale</h5><p>Fast, accurate billing with automatic stock deduction and receipt generation.</p></div></div>
            <div class="col-md-4"><div class="feature-card"><div class="feature-icon"><i class="fa fa-file-medical"></i></div><h5>Prescription Management</h5><p>Upload and verify prescription proofs for regulated medications.</p></div></div>
            <div class="col-md-4"><div class="feature-card"><div class="feature-icon"><i class="fa fa-calendar-times"></i></div><h5>Expiry Tracking</h5><p>Monitor batch expiry dates and get alerts for expiring medicines.</p></div></div>
            <div class="col-md-4"><div class="feature-card"><div class="feature-icon"><i class="fa fa-truck"></i></div><h5>Supplier Management</h5><p>Manage supplier contacts and track procurement orders efficiently.</p></div></div>
            <div class="col-md-4"><div class="feature-card"><div class="feature-icon"><i class="fa fa-shield-alt"></i></div><h5>Role-Based Security</h5><p>Admin approval for staff accounts with strict role-based access control.</p></div></div>
        </div>
    </div>
</section>

<section class="roles-section">
    <div class="container">
        <h2 class="text-center fw-800 mb-2" style="font-weight:800;color:#333;">Built for your team</h2>
        <p class="text-center text-muted mb-5">Different roles with tailored access</p>
        <div class="row g-4">
            <div class="col-md-4"><div class="role-card"><div class="role-icon"><i class="fa fa-user-shield"></i></div><h5 class="fw-700">Admin</h5><p class="text-muted">Full system access, user approvals, financial reports</p></div></div>
            <div class="col-md-4"><div class="role-card"><div class="role-icon"><i class="fa fa-user-md"></i></div><h5 class="fw-700">Pharmacist</h5><p class="text-muted">Inventory, prescriptions, expiry monitoring</p></div></div>
            <div class="col-md-4"><div class="role-card"><div class="role-icon"><i class="fa fa-user-tie"></i></div><h5 class="fw-700">Sales Clerk</h5><p class="text-muted">Point of sale, transactions, receipt issuance</p></div></div>
        </div>
    </div>
</section>

<footer>
    <p><strong>Pharmastream System</strong> &copy; {{ date('Y') }} &mdash; All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

