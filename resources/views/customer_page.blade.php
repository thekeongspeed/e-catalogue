<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $name }} - Katalog</title>
   
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
            background-color: #f9f9f9;
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
            padding: 20px 25px;
            color: white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .nav-title { font-size: 18px; font-weight: 500; margin-left: 15px; letter-spacing: 0.5px; }
        .btn-home { color: white; font-size: 24px; text-decoration: none; transition: transform 0.2s; }
        .btn-home:hover { transform: scale(1.1); color: #e0e0e0; }

        /* --- STORE IDENTITY --- */
        .store-header {
            text-align: center;
            padding: 40px 20px;
            background: white;
            margin-bottom: 30px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.03);
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
        }
        .store-logo {
            height: 80px;
            width: auto;
            object-fit: contain;
            margin-bottom: 15px;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
            transition: transform 0.3s;
        }
        .store-logo:hover { transform: scale(1.05); }
        .store-name {
            font-size: 28px;
            font-weight: 700;
            text-transform: uppercase;
            color: #222;
            letter-spacing: 2px;
        }

        /* --- ITEM CARD DESIGN --- */
        .item-card {
            background: white;
            border-radius: 15px;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            border: 1px solid transparent;
            text-decoration: none;
            color: inherit;
            height: 100%;
        }

        /* Hover Effect Desktop */
        .item-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(26, 69, 156, 0.15); /* Bayangan Biru Halus */
            border-color: #1a459c;
        }

        .item-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 12px;
            background-color: #f8f9fa;
            border: 1px solid #eee;
        }

        .item-info { flex-grow: 1; }
        .item-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        .item-subtitle {
            font-size: 13px;
            color: #888;
        }
        .arrow-icon {
            color: #ccc;
            transition: 0.3s;
        }
        .item-card:hover .arrow-icon {
            color: #1a459c;
            transform: translateX(5px);
        }

        /* --- ANIMATION (Fade In Up) --- */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-card {
            opacity: 0; /* Hidden initially */
            animation: fadeInUp 0.6s ease-out forwards;
        }

        /* --- MOBILE SPECIFIC --- */
        @media (max-width: 768px) {
            body { background-size: 80%; }
            .store-header { padding: 30px 20px; border-radius: 0 0 20px 20px; }
            .store-logo { height: 60px; }
            .store-name { font-size: 24px; }
            
            /* Tampilan Mobile: Tombol Biru Pill (Seperti Desain Awal) */
            .item-card {
                background-color: #1a459c;
                color: white;
                border-radius: 50px; /* Pill Shape */
                padding: 8px 10px 8px 20px; /* Padding kiri lebih besar */
                box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            }
            .item-card:hover { transform: scale(1.02); box-shadow: 0 6px 12px rgba(0,0,0,0.3); }
            
            .item-img {
                width: 50px; height: 50px;
                border-radius: 50%; /* Gambar Bulat di HP */
                border: 2px solid white;
            }
            
            .item-title { color: white; font-size: 15px; margin: 0; }
            .item-subtitle { display: none; /* Sembunyikan detail di list HP biar bersih */ }
            .arrow-icon { color: rgba(255,255,255,0.7); }
            .item-card:hover .arrow-icon { color: white; }
        }
    </style>
</head>
<body>

    <div class="navbar-custom">
        <a href="/" class="btn-home">
            <i class="fas fa-home"></i>
        </a>
        <span class="nav-title">Katalog Produk</span>
    </div>

    <div class="store-header">
        <img src="{{ asset('logos/' . $name . '.png') }}" class="store-logo" alt="Logo" onerror="this.style.display='none'">
        <div class="store-name">{{ $name }}</div>
        
        <div class="mt-3">
            <a href="/print-customer?name={{ $name }}" target="_blank" class="btn btn-outline-dark rounded-pill px-4">
                <i class="fas fa-print me-2"></i> Download Full Catalog PDF
            </a>
        </div>
    </div>


    <div class="container pb-5">
        <div class="row g-3"> @foreach($products as $index => $p)
            <div class="col-12 col-md-6 col-lg-4">
                
                <a href="/detail/{{ $p->id }}" class="item-card animate-card" style="animation-delay: {{ $index * 0.1 }}s">
                    
                  @if(!empty($p->thumbnail))
                            <img src="{{ asset('storage/' . $p->thumbnail) }}" class="item-img">
                       @elseif(!empty($p->foto_barang)) 
                            <img src="{{ asset('storage/' . $p->foto_barang) }}" class="item-img">
                        @else
                            <div class="item-img d-flex align-items-center justify-content-center bg-light text-muted small border">
                                <i class="fas fa-image fa-lg"></i>
                            </div>
                        @endif
                        
                        <div class="item-info ms-3">
                            <div class="item-title">{{ $p->nama_barang }}</div>
                            <div class="item-subtitle text-muted small">Klik untuk detail</div>
                        </div>
    
                        <i class="fas fa-chevron-right arrow-icon ms-auto"></i>
                </a>

            </div>
            @endforeach
        </div>

        @if($products->isEmpty())
            <div class="text-center py-5 text-muted animate-card">
                <i class="fas fa-box-open fa-3x mb-3 text-secondary"></i>
                <p>Belum ada item untuk kategori ini.</p>
            </div>
        @endif
    </div>

</body>
</html>