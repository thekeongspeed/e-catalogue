<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <title>E-Catalogue UT</title>
    <link rel="icon" href="{{ asset('bg-watermark.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('bg-watermark.png') }}" type="image/x-icon">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
            position: relative;
        }
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: url('/bg-watermark.png');
            background-position: center;
            background-repeat: no-repeat;
            background-size: 40%;
            opacity: 0.08; /* Ubah ini untuk mengatur ketipisan */
            z-index: -1;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="login-card text-center">
    <h3 class="mb-4">🔐 Admin Access</h3>
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="/login" method="POST">
        @csrf
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Masukkan Password Admin" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Masuk</button>
        <a href="/" class="btn btn-link mt-2 text-decoration-none text-muted">Kembali ke Dashboard</a>
    </form>
</div>

</body>
</html>