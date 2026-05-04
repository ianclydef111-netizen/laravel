<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pharmastream</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: url('https://img.freepik.com/premium-photo/closeup-digital-prescription-being-filled-processed-through-online-pharmacy_995578-18135.jpg') center/cover no-repeat; min-height: 100vh; display: flex; align-items: center; position: relative; }
        body::before { content: ''; position: absolute; inset: 0; background: rgba(0,0,0,0.55); pointer-events: none; z-index: 0; }
        .container { position: relative; z-index: 1; }
        .card { border: 2px solid white; border-radius: 20px; background: transparent; color: white; }
        .card .text-muted { color: rgba(255,255,255,0.85) !important; }
        .card .form-label { color: white; }
        .card .form-control { background: transparent; border: 1px solid rgba(255,255,255,0.5); color: white; }
        .card .form-control::placeholder { color: rgba(255,255,255,0.6); }
        .card .form-control:focus { background: rgba(255,255,255,0.1); border-color: white; color: white; box-shadow: 0 0 0 0.25rem rgba(255,255,255,0.25); }
        .card .form-check-input { background-color: transparent; border-color: rgba(255,255,255,0.5); }
        .card .form-check-input:checked { background-color: white; border-color: white; }
        .btn-primary { background: transparent; border: 2px solid white; color: white; }
        .btn-primary:hover { background: white; border-color: white; color: #0ba8ff; }
        hr { border-color: rgba(255,255,255,0.3); }
        a.text-primary { color: white !important; font-weight: 600; }
        a.text-primary:hover { color: #e0e0e0 !important; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="text-center mb-4"><span style="font-size:1.5rem;font-weight:800;color:white;"><i class="fa fa-capsules me-2"></i>Pharmastream</span></div>
            <div class="card shadow-lg p-4">
                <h4 class="text-center fw-bold mb-1">Welcome Back</h4>
                <p class="text-center text-muted small mb-4">Sign in to your account</p>

                @if(session('success'))
                    <div class="alert alert-success small">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger small">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label small" for="remember">Remember Me</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="fa fa-sign-in-alt me-2"></i>Login</button>
                </form>
                <hr>
                <p class="text-center mb-0 small">No account? <a href="{{ route('register') }}" class="text-primary">Register here</a></p>
                <p class="text-center mb-0 small mt-2"><a href="{{ route('home') }}" class="text-muted"><i class="fa fa-arrow-left me-1"></i>Back to Home</a></p>
            </div>
        </div>
    </div>
</body>
</html>
