<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Catalogue UT</title>
    <link rel="icon" href="{{ asset('bg-watermark.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('bg-watermark.png') }}" type="image/x-icon">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            min-height: 100vh;
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

        /* --- HEADER --- */
        .navbar-custom {
            background-color: #1a459c;
            padding: 20px 30px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .brand-text {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* --- ADMIN BUTTON --- */
        .btn-admin {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 50px;
            padding: 8px 25px;
            font-weight: 500;
            font-size: 14px;
            text-decoration: none;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.3);
            transition: all 0.3s ease;
        }
        .btn-admin:hover {
            background-color: white;
            color: #1a459c;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        /* --- LOGO CARD DESIGN --- */
        .logo-card {
            background: white;
            border-radius: 20px;
            height: 180px; /* Tinggi kartu tetap */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); /* Efek membal */
            border: 1px solid transparent;
            cursor: pointer;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        /* Efek Hover */
        .logo-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 15px 30px rgba(26, 69, 156, 0.15);
            border-color: #1a459c;
        }

        /* Gambar Logo */
        .logo-img {
            max-width: 90%;
            max-height: 100px;
            object-fit: contain;
            transition: transform 0.3s;
        }
        .logo-card:hover .logo-img {
            transform: scale(1.1); /* Logo zoom dikit saat hover */
        }

        /* Teks Nama Toko (Fallback jika gambar rusak) */
        .fallback-text {
            color: #1a459c;
            font-weight: 700;
            font-size: 18px;
            text-align: center;
            text-transform: uppercase;
        }

        /* --- ANIMATION --- */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-card {
            opacity: 0; /* Hidden by default */
            animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        /* --- MOBILE RESPONSIVE --- */
        @media (max-width: 768px) {
            body { background-size: 80%; }
            .navbar-custom { padding: 15px 20px; }
            .brand-text { font-size: 20px; }
            
            .logo-card {
                height: 140px; /* Lebih pendek di HP */
                border-radius: 15px;
            }
            .logo-img { max-height: 70px; }
        }
    </style>
</head>
<body>

    <nav class="navbar-custom">
        <div class="brand-text">
            <i class="fas fa-layer-group me-2"></i>E-Catalogue
        </div>
        
        <div>
            @if(session('is_admin'))
                <a href="/manage" class="btn-admin me-2"><i class="fas fa-plus-circle"></i> Input</a>
                <a href="/logout" class="btn-admin"><i class="fas fa-sign-out-alt"></i> Logout</a>
            @else
                <a href="/login" class="btn-admin"><i class="fas fa-lock"></i> Admin</a>
            @endif
        </div>
    </nav>

    <div class="container py-5">
        
        <div class="text-center mb-5 animate-card" style="animation-delay: 0s">
            <h2 style="font-weight: 700; color: #333;">Pilih Katalog Toko</h2>
            <p class="text-muted">Klik pada logo untuk melihat koleksi produk</p>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach($customers as $index => $c)
            <div class="col-6 col-md-4 col-lg-3">
                
                <a href="/customer/{{ $c->nama_customer }}" class="logo-card animate-card" style="animation-delay: {{ $index * 0.1 }}s">
                    
                    <img src="{{ asset('logos/' . $c->nama_customer . '.png') }}" 
                         class="logo-img" 
                         alt="{{ $c->nama_customer }}"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    
                    <div class="fallback-text" style="display:none;">
                        {{ $c->nama_customer }}
                    </div>

                </a>

            </div>
            @endforeach
        </div>

        @if($customers->isEmpty())
            <div class="text-center py-5 text-muted animate-card">
                <i class="fas fa-folder-open fa-3x mb-3 text-secondary"></i>
                <p>Belum ada data toko tersedia.</p>
                <p>Silakan login admin untuk menambah data.</p>
            </div>
        @endif

    </div>

</body>
</html>