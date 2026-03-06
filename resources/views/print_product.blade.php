<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->nama_barang }}</title>
    @php
        $bgPath = public_path('background.png');
        $base64Bg = '';
        if(file_exists($bgPath)){
            $base64Bg = 'data:image/png;base64,' . base64_encode(file_get_contents($bgPath));
        }
    @endphp

    
    <style>
    
        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/Montserrat-Regular.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/Montserrat-Bold.ttf') }}") format('truetype');
        }

        /* --- 2. DEKLARASI FONT LOKAL: POPPINS --- */
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/Poppins-Regular.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/Poppins-Bold.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 800;
            src: url("{{ public_path('fonts/Poppins-ExtraBold.ttf') }}") format('truetype');
        }

        /* --- 3. RESET & SETUP BODY --- */
        @page { margin: 0px; }
        body { 
            margin: 0px; padding: 0px;
            font-family: 'Montserrat', 'Arial', sans-serif; 
            color: #333; 
            background: transparent;
            counter-reset: page; 
        }
        
        .page-break { page-break-after: always; height: 0; margin: 0; padding: 0; border: none; display: block; clear: both; visibility: hidden; line-height: 0;}
        .avoid-break { page-break-inside: avoid; }

        /* WARNA UTAMA */
        :root { --main-blue: #1a459c; }

        /* --- 4. TERAPKAN POPPINS UNTUK JUDUL --- */
        .cover-title, .cover-title-customer, .cover-slogan,
        .ph-title, .ph-subtitle, .section-title, 
        .dim-table th, .part-title {
            font-family: 'Poppins', sans-serif !important;
        }

        /* --- GLOBAL HEADER STYLE --- */
        .page-header { margin: 0; padding: 40px 40px 20px 40px; }
        .ph-title { font-size: 26px; font-weight: bold; color: #1a459c; text-transform: uppercase; margin: 0; }
        .ph-subtitle { font-size: 15px; color: #666; text-transform: uppercase; margin-top: 5px; }
        .ph-line { width: 100%; height: 2px; background-color: #eaeaea; margin-top: 15px; }

        /* --- HALAMAN 1: COVER --- */
        .cover-page { position: relative; 
            width: 100%; 
            height: 1000px; /* DIKURANGI AGAR TIDAK MUNCUL HALAMAN KOSONG */
            background: transparent;  }
        .cover-sidebar {  position: absolute; 
            top: -60px;     /* WAJIB PAKAI px */
            height: 1500px;  /* WAJIB PAKAI px, ditarik tembus margin bawah */
            left: -60px;    /* WAJIB PAKAI px, ditarik tembus margin kiri */
            width: 30%; 
            background-color: #1a459c; 
            z-index: -1;  }
        .cover-content { position: absolute; top: 150px; left: 25%; right: 40px; z-index: 2; }
        
        .cover-title-customer { font-size: 45px; font-weight: 800; color: #4e4e4e; line-height: 1.1; text-transform: uppercase; margin-bottom: 5px; }
        .cover-title { font-size: 38px; font-weight: 800; color: #0d2c6b; line-height: 1.1; text-transform: uppercase; margin-bottom: 5px; padding-bottom: 5px; border-bottom: 4px solid #1a459c; display: inline-block; }

        .cover-image { width: 100%; height: 450px; background: #fafafa; border-radius: 8px; text-align: center; margin-bottom: 5px; display: flex; align-items: center; justify-content: center; }
        .cover-image img { max-height: 95%; max-width: 95%; width: auto; height: auto; object-fit: contain; padding-top: 2.5%; }

        .cover-footer { position: absolute; text-align: right;  bottom: 65px; right: 40px;  z-index: 999;}
        .cover-slogan { font-size: 20px; font-weight: bold; color: #333; }

        /* --- HALAMAN 2: SPESIFIKASI --- */
        .spec-container { padding: 0 40px; }
        .product-info { margin-bottom: 30px; }
        .product-info table { width: 100%; font-size: 13px; border-collapse: collapse; }
        .product-info td { padding: 8px 0; border-bottom: 1px dashed #eee; }
        .product-info .label { font-weight: bold; width: 140px; color: #3d3d3d; }
        .product-info .value { color: #000000; }

        .section-title { font-size: 13px; text-transform: uppercase; color: #1a459c; font-weight: bold; letter-spacing: 1px; margin-bottom: 10px; }

        
        /* Tabel Dimensi (Modern Style) */
        .dim-table { width: 100%; border-collapse: collapse; font-size: 12px; border: 1px solid #e0e0e0; margin-bottom: 30px; }
        .dim-table th { background-color: #1a459c; color: white; padding: 10px 15px; text-align: center; font-weight: bold; text-transform: uppercase; }
        .dim-table td { padding: 10px 15px; text-align: center; border-bottom: 1px solid #eee; color: #444; }
        .dim-table tr:nth-child(even) { background-color: #f8fafd; }

        /* --- HALAMAN 3: PARTS --- */
        .parts-grid { margin: 0 40px; font-size: 0; }
        .part-item { width: 48%; display: inline-block; vertical-align: top; margin-bottom: 30px; margin-right: 2%; font-size: 12px; page-break-inside: avoid; }
        .part-title { font-weight: bold; font-size: 14px; color: #1a459c; margin-bottom: 10px; line-height: 1.5; margin-top: 10px; padding-top: 5px; overflow: hidden; }
        
        .part-img-box { width: 100%; height: 160px; line-height: 160px; text-align: center; border: 1px solid #eee; background: #fafafa; margin-bottom: 10px; overflow: hidden; }
        .part-img-box img { vertical-align: middle; max-width: 90%; max-height: 90%; width: auto; height: auto; }
        
        .part-detail-table { width: 100%; font-size: 12px; }
        .part-detail-table td { padding: 4px 0; vertical-align: top; border-bottom: 1px solid #f5f5f5; }
        .pd-label { width: 40%; font-weight: bold; color: #000000; }
        .pd-val { width: 60%; color: #000000; }

        /* --- HALAMAN 4: PROJECT REFERENCES --- */
        .project-hero { width: 100%; height: 350px; margin-bottom: 10px; border-radius: 4px; overflow: hidden; }
        .project-hero img { width: 100%; height: 100%; object-fit: cover; }
        
        .project-thumbnails { width: 100%; font-size: 0; }
        .proj-thumb { width: 32%; height: 130px; display: inline-block; margin-right: 1%; margin-bottom: 10px; border-radius: 4px; overflow: hidden; }
        .proj-thumb img { width: 100%; height: 100%; object-fit: cover; }

        /* --- FOOTER OTOMATIS (PAGE NUMBER) --- */
        .footer-page { position: fixed; bottom: 30px; right: 40px; text-align: right; z-index: 999; }
        .footer-line { width: 50px; height: 3px; background: #1a459c; margin-left: auto; margin-bottom: 5px; }
        .page-num:after { content: counter(page); font-weight: bold; font-size: 12px; color: #666; font-family: 'Poppins', sans-serif !important; }

        /* --- LAYOUT PROJECT REFERENCE (BENTO GRID) --- */
  .project-page-fixed {
          page-break-before: always; /* Pindah halaman */
            
          margin: 0;
          padding: 40px 40px 20px 40px;
        }

        /* Style Header agar ikut margin wrapper */
        .project-header-clean {
            padding-bottom: 10px;
            margin-bottom: 5px;
        }

        /* Grid Gambar */
        .grid-table {
            width: 100%; /* Ini aman karena dia 100% dari wrapper yang sudah dikecilkan margin */
            border-collapse: separate;
            border-spacing: 10px;
        }
        
        .grid-box {
            width: 100%;
            background-color: #f8f9fa;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            border-radius: 4px;
            border: 1px solid #eee;
        }
        
        .grid-label {
            position: absolute; bottom: 0; left: 0;
            background: rgba(0,0,0,0.6); color: white;
            font-size: 10px; padding: 6px 10px;
            box-sizing: border-box;
        }


        /* --- 4. STYLE UNTUK LOGO --- */
       .company-logo-link {
            position: absolute;
            top: 40px;
            right: 40px;
            z-index: 999; /* Pastikan paling atas agar tidak tertutup elemen lain */
            display: block;
        }

        /* --- GAMBAR LOGONYA --- */
        .company-logo {
            width: 150px; /* Sesuaikan ukuran logo di sini */
            height: auto;
            border: none;
        }

        .customer-logo {
            max-width: 200px; /* Batas maksimal lebar logo customer */
            height: auto;
            margin-bottom: 5px; /* Jarak antara logo dan teks judul di bawahnya */
            display: block;
        }

        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1; 
            opacity: 0.35; /* Sesuaikan ketebalan background */
            background-image: url("{{ $base64Bg }}");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }


    </style>
</head>
<body>

@if($base64Bg != '')
        <div class="background"></div>
    @endif


    <div class="footer-page">
        <div class="footer-line"></div>
        <span class="page-num"></span>
    </div>

    <div class="cover-page">
        <div class="cover-sidebar"></div>
        <a href="https://www.spectrum-unitec.com" class="company-logo-link">
        <img src="{{ public_path('/logo-perusahaan.png') }}" class="company-logo" style="border: none;">
        </a>

        <div class="cover-content">

       @if(isset($customer) && !empty($customer->logo_path))
    @php
        $logoPath = public_path('storage/' . $customer->logo_path);
    @endphp

    @if(file_exists($logoPath))
        <img src="{{ $logoPath }}" class="customer-logo">
    @endif
@endif


            <div class="cover-title-customer">
                {{ $product->nama_customer }}
            </div>

            <div class="cover-title">
                {{ strtoupper($product->nama_barang) }}
            </div>

            <div class="cover-image">
                @if($gallery->count() > 1)
                    <img src="{{ public_path('storage/' . $gallery->skip(1)->first()->image_path) }}">
                @elseif($gallery->isNotEmpty())
                    <img src="{{ public_path('storage/' . $gallery->first()->image_path) }}">
                @else
                    <div style="padding-top:180px; color:#ccc; font-style:italic;">No Image Available</div>
                @endif
            </div>

            
        </div>

    </div>


    

        <div class="cover-footer">
                <div class="cover-slogan">
                    <span style="font-size: 16px; font-weight:normal; color:#666;">Smart Solutions for Better Life</span>
                </div>
            </div>


   <div class="page-break"></div>

{{-- ===== HALAMAN SPESIFIKASI ===== --}}
<div class="page-header">
    <h1 class="ph-title">{{ $product->nama_barang }}</h1>
    <h2 class="ph-subtitle">Technical Specification</h2>
    <div class="ph-line"></div>
</div>

<div class="spec-container">
    {{-- Foto --}}
    <div style="text-align:center; height:280px; margin-bottom:20px; border-radius:8px; overflow:hidden; background:#fafafa; border:1px solid #eee;">
        @if($gallery->isNotEmpty())
            <img src="{{ public_path('storage/' . $gallery->first()->image_path) }}" style="max-height:100%; max-width:100%; object-fit:contain;">
        @else
            <div style="padding-top:120px; color:#ccc; font-style:italic;">No Image Available</div>
        @endif
    </div>

    {{-- Info Cards --}}
    <table style="width:100%; border-collapse:separate; border-spacing:8px; margin-bottom:20px;">
        <tr>
            <td style="width:33%; vertical-align:top;">
                <div style="background:#f8f9fa; border-radius:8px; padding:12px 15px; border:1px solid #eee;">
                    <div style="font-size:10px; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Material</div>
                    <div style="font-size:13px; font-weight:bold; color:#333;">{{ $product->jenis_material ?? '-' }}</div>
                </div>
            </td>
            <td style="width:33%; vertical-align:top;">
                <div style="background:#f8f9fa; border-radius:8px; padding:12px 15px; border:1px solid #eee;">
                    <div style="font-size:10px; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Finishing</div>
                    <div style="font-size:13px; font-weight:bold; color:#333;">{{ $product->finishing ?? '-' }}</div>
                </div>
            </td>
            <td style="width:33%; vertical-align:top;">
                <div style="background:#f8f9fa; border-radius:8px; padding:12px 15px; border:1px solid #eee;">
                    <div style="font-size:10px; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Max Load</div>
                    <div style="font-size:13px; font-weight:bold; color:#333;">{{ !empty($product->max_load) ? $product->max_load . ' kg' : '-' }}</div>
                </div>
            </td>
        </tr>
        <tr>
            <td style="vertical-align:top;">
                <div style="background:#f8f9fa; border-radius:8px; padding:12px 15px; border:1px solid #eee;">
                    <div style="font-size:10px; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Divisi</div>
                    <div style="font-size:13px; font-weight:bold; color:#333;">{{ $product->divisi ?? '-' }}</div>
                </div>
            </td>
            <td colspan="2" style="vertical-align:top;">
                <div style="background:#f8f9fa; border-radius:8px; padding:12px 15px; border:1px solid #eee;">
                    <div style="font-size:10px; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Application</div>
                    <div style="font-size:13px; font-weight:bold; color:#333;">{{ $product->application ?? '-' }}</div>
                </div>
            </td>
        </tr>
    </table>

    {{-- Dimension Table --}}
    <div style="font-size:12px; font-weight:bold; text-transform:uppercase; letter-spacing:1px; color:#1a459c; margin-bottom:10px;">
        Dimension Details
    </div>
    <div style="border-radius:8px; overflow:hidden; border:1px solid #eee; margin-bottom:20px;">
        <table class="dim-table" style="margin-bottom:0;">
            <thead>
                <tr>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Dimension</th>
                    <th>Color</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($dimensions) && count($dimensions) > 0)
                    @foreach($dimensions as $dim)
                    <tr>
                        <td style="font-weight:bold; color:#1a459c;">{{ $dim->item_code ?? '-' }}</td>
                        <td>{{ $dim->item_name ?? '-' }}</td>
                        <td>{{ $dim->panjang ?? '-' }}</td>
                        <td>{{ $dim->color ?? '-' }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr><td colspan="4" style="padding:15px; font-style:italic; color:#999;">- Data dimensi tidak tersedia -</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>


@if(!$items->isEmpty())
<div class="page-break"></div>

{{-- ===== HALAMAN COMPONENT PARTS ===== --}}
<div class="page-header">
    <h1 class="ph-title">{{ $product->nama_barang }}</h1>
    <h2 class="ph-subtitle">Component Parts</h2>
    <div class="ph-line"></div>
</div>

<div class="spec-container">
    @if($items->isEmpty())
        <div style="text-align:center; color:#999; padding:40px 0; font-style:italic;">- No component parts available -</div>
    @else
        <table style="width:100%; border-collapse:separate; border-spacing:10px;">
            @foreach($items->chunk(2) as $chunk)
                @php $part = $chunk->values(); @endphp
                <tr>
                   {{-- PART KIRI --}}
<td style="width:50%; vertical-align:top; padding-right:5px;">
    @if(isset($part[0]))
    <div style="border:1px solid #e0e0e0; border-radius:8px; overflow:hidden; background:#fff;">
        <div style="padding:12px 15px; border-bottom:1px solid #f0f0f0;">
            <div style="font-weight:bold; font-size:13px; color:#0d2c6b; font-family:'Poppins',sans-serif;">{{ $part[0]->nama_item }}</div>
        </div>
        <div style="width:100%; height:160px; background:#f8f9fa; text-align:center; border-bottom:1px solid #f0f0f0; line-height:160px;">
            @if($part[0]->foto_item)
                <img src="{{ public_path('storage/' . $part[0]->foto_item) }}" style="max-width:85%; max-height:140px; object-fit:contain; vertical-align:middle;">
            @else
                <span style="color:#ccc; font-size:11px; vertical-align:middle;">No Image</span>
            @endif
        </div>
        <div style="height:90px; padding:10px 15px; font-size:10px; color:#666; line-height:1.6; border-bottom:1px solid #f0f0f0; background:#fafafa; overflow:hidden;">
            {{ !empty($part[0]->deskripsi) ? Str::limit($part[0]->deskripsi, 200) : '' }}
        </div>
        <div style="background:#1a459c; padding:7px 15px;">
            <div style="font-size:10px; font-weight:bold; color:#fff; text-transform:uppercase; letter-spacing:1px; font-family:'Poppins',sans-serif;">Technical Specification</div>
        </div>
        <table style="width:100%; border-collapse:collapse; font-size:11px; font-family:'Montserrat',sans-serif;">
            <tr><td style="color:#888; padding:6px 15px; width:45%; border-bottom:1px solid #f0f0f0;">Material</td><td style="color:#222; padding:6px 15px; font-weight:bold; border-bottom:1px solid #f0f0f0;">{{ $part[0]->tipe ?? '-' }}</td></tr>
            <tr style="background:#fafafa;"><td style="color:#888; padding:6px 15px; border-bottom:1px solid #f0f0f0;">Dimension</td><td style="color:#222; padding:6px 15px; font-weight:bold; border-bottom:1px solid #f0f0f0;">{{ !empty($part[0]->dimensi_part) ? (stripos($part[0]->dimensi_part, 'mm') === false ? $part[0]->dimensi_part . ' mm' : $part[0]->dimensi_part) : '-' }}</td></tr>
            <tr><td style="color:#888; padding:6px 15px; border-bottom:1px solid #f0f0f0;">Configuration</td><td style="color:#222; padding:6px 15px; font-weight:bold; border-bottom:1px solid #f0f0f0;">{{ $part[0]->konfigurasi ?? '-' }}</td></tr>
            <tr style="background:#fafafa;"><td style="color:#888; padding:6px 15px;">Load Capacity</td><td style="color:#222; padding:6px 15px; font-weight:bold;">{{ !empty($part[0]->load_capacity) ? (stripos($part[0]->load_capacity, 'kg') === false ? $part[0]->load_capacity . ' kg' : $part[0]->load_capacity) : '-' }}</td></tr>
        </table>
    </div>
    @endif
</td>

{{-- PART KANAN --}}
<td style="width:50%; vertical-align:top; padding-left:5px;">
    @if(isset($part[1]))
    <div style="border:1px solid #e0e0e0; border-radius:8px; overflow:hidden; background:#fff;">
        <div style="padding:12px 15px; border-bottom:1px solid #f0f0f0;">
            <div style="font-weight:bold; font-size:13px; color:#0d2c6b; font-family:'Poppins',sans-serif;">{{ $part[1]->nama_item }}</div>
        </div>
        <div style="width:100%; height:160px; background:#f8f9fa; text-align:center; border-bottom:1px solid #f0f0f0; line-height:160px;">
            @if($part[1]->foto_item)
                <img src="{{ public_path('storage/' . $part[1]->foto_item) }}" style="max-width:85%; max-height:140px; object-fit:contain; vertical-align:middle;">
            @else
                <span style="color:#ccc; font-size:11px; vertical-align:middle;">No Image</span>
            @endif
        </div>
        <div style="height:90px; padding:10px 15px; font-size:10px; color:#666; line-height:1.6; border-bottom:1px solid #f0f0f0; background:#fafafa; overflow:hidden;">
            {{ !empty($part[1]->deskripsi) ? Str::limit($part[1]->deskripsi, 200) : '' }}
        </div>
        <div style="background:#1a459c; padding:7px 15px;">
            <div style="font-size:10px; font-weight:bold; color:#fff; text-transform:uppercase; letter-spacing:1px; font-family:'Poppins',sans-serif;">Technical Specification</div>
        </div>
        <table style="width:100%; border-collapse:collapse; font-size:11px; font-family:'Montserrat',sans-serif;">
            <tr><td style="color:#888; padding:6px 15px; width:45%; border-bottom:1px solid #f0f0f0;">Material</td><td style="color:#222; padding:6px 15px; font-weight:bold; border-bottom:1px solid #f0f0f0;">{{ $part[1]->tipe ?? '-' }}</td></tr>
            <tr style="background:#fafafa;"><td style="color:#888; padding:6px 15px; border-bottom:1px solid #f0f0f0;">Dimension</td><td style="color:#222; padding:6px 15px; font-weight:bold; border-bottom:1px solid #f0f0f0;">{{ !empty($part[1]->dimensi_part) ? (stripos($part[1]->dimensi_part, 'mm') === false ? $part[1]->dimensi_part . ' mm' : $part[1]->dimensi_part) : '-' }}</td></tr>
            <tr><td style="color:#888; padding:6px 15px; border-bottom:1px solid #f0f0f0;">Configuration</td><td style="color:#222; padding:6px 15px; font-weight:bold; border-bottom:1px solid #f0f0f0;">{{ $part[1]->konfigurasi ?? '-' }}</td></tr>
            <tr style="background:#fafafa;"><td style="color:#888; padding:6px 15px;">Load Capacity</td><td style="color:#222; padding:6px 15px; font-weight:bold;">{{ !empty($part[1]->load_capacity) ? (stripos($part[1]->load_capacity, 'kg') === false ? $part[1]->load_capacity . ' kg' : $part[1]->load_capacity) : '-' }}</td></tr>
        </table>
    </div>
    @endif
</td>
                </tr>
            @endforeach
        </table>
    @endif
</div>
@endif

{{-- ===== HALAMAN PROJECT REFERENCES ===== --}}
@if(count($projects) > 0)
    @foreach($projects->chunk(5) as $chunk)
        @php $imgs = $chunk->values(); @endphp

        <div class="project-page-fixed">
            <div class="project-header-clean">
                <h1 class="ph-title">{{ $product->nama_barang }}</h1>
                <h2 class="ph-subtitle" style="text-transform:uppercase; font-weight:bold; color:#333; font-size:13px; letter-spacing:1px;">
                    Project References & Installation Highlights
                </h2>
                <div class="ph-line"></div>
            </div>

            {{-- HERO --}}
            @if(isset($imgs[0]))
            <div style="margin-bottom:6px;">
                <div style="width:100%; height:300px; border-radius:6px 6px 0 0; overflow:hidden;">
                    <img src="{{ public_path('storage/' . $imgs[0]->image_path) }}" style="width:100%; height:100%; object-fit:cover; display:block;">
                </div>
                <div style="background:#1a459c; border-radius:0 0 6px 6px; padding:8px 14px;">
                    <div style="font-size:12px; font-weight:bold; color:#fff; font-family:'Poppins',sans-serif; text-transform:uppercase;">
                        {{ $imgs[0]->place ?? '' }}
                    </div>
                </div>
                @if(!empty($imgs[0]->description))
                <div style="padding:6px 4px; font-size:10px; color:#555; line-height:1.6;">
                    {{ Str::words($imgs[0]->description, 10) }}
                </div>
                @endif
            </div>
            @endif

            {{-- ROW 1 --}}
            @if(isset($imgs[1]) || isset($imgs[2]))
            <table style="width:100%; border-collapse:separate; border-spacing:8px 0; margin-bottom:6px;">
                <tr>
                    <td style="width:50%; padding-right:4px; vertical-align:top;">
                        @if(isset($imgs[1]))
                        <div>
                            <div style="height:170px; border-radius:6px 6px 0 0; overflow:hidden;">
                                <img src="{{ public_path('storage/' . $imgs[1]->image_path) }}" style="width:100%; height:100%; object-fit:cover; display:block;">
                            </div>
                            <div style="background:#1a459c; border-radius:0 0 6px 6px; padding:6px 12px;">
                                <div style="font-size:10px; font-weight:bold; color:#fff; font-family:'Poppins',sans-serif; text-transform:uppercase;">{{ $imgs[1]->place ?? '' }}</div>
                            </div>
                            @if(!empty($imgs[1]->description))
                            <div style="padding:5px 2px; font-size:9px; color:#555; line-height:1.5;">{{ Str::words($imgs[1]->description, 10) }}</div>
                            @endif
                        </div>
                        @endif
                    </td>
                    <td style="width:50%; padding-left:4px; vertical-align:top;">
                        @if(isset($imgs[2]))
                        <div>
                            <div style="height:170px; border-radius:6px 6px 0 0; overflow:hidden;">
                                <img src="{{ public_path('storage/' . $imgs[2]->image_path) }}" style="width:100%; height:100%; object-fit:cover; display:block;">
                            </div>
                            <div style="background:#1a459c; border-radius:0 0 6px 6px; padding:6px 12px;">
                                <div style="font-size:10px; font-weight:bold; color:#fff; font-family:'Poppins',sans-serif; text-transform:uppercase;">{{ $imgs[2]->place ?? '' }}</div>
                            </div>
                            @if(!empty($imgs[2]->description))
                            <div style="padding:5px 2px; font-size:9px; color:#555; line-height:1.5;">{{ Str::words($imgs[2]->description, 10) }}</div>
                            @endif
                        </div>
                        @endif
                    </td>
                </tr>
            </table>
            @endif

            {{-- ROW 2 --}}
            @if(isset($imgs[3]) || isset($imgs[4]))
            <table style="width:100%; border-collapse:separate; border-spacing:8px 0; margin-top:15px;">
                <tr>
                    <td style="width:50%; padding-right:4px; vertical-align:top;">
                        @if(isset($imgs[3]))
                        <div>
                            <div style="height:170px; border-radius:6px 6px 0 0; overflow:hidden;">
                                <img src="{{ public_path('storage/' . $imgs[3]->image_path) }}" style="width:100%; height:100%; object-fit:cover; display:block;">
                            </div>
                            <div style="background:#1a459c; border-radius:0 0 6px 6px; padding:6px 12px;">
                                <div style="font-size:10px; font-weight:bold; color:#fff; font-family:'Poppins',sans-serif; text-transform:uppercase;">{{ $imgs[3]->place ?? '' }}</div>
                            </div>
                            @if(!empty($imgs[3]->description))
                            <div style="padding:5px 2px; font-size:9px; color:#555; line-height:1.5;">{{ Str::words($imgs[3]->description, 10) }}</div>
                            @endif
                        </div>
                        @endif
                    </td>
                    <td style="width:50%; padding-left:4px; vertical-align:top;">
                        @if(isset($imgs[4]))
                        <div>
                            <div style="height:170px; border-radius:6px 6px 0 0; overflow:hidden;">
                                <img src="{{ public_path('storage/' . $imgs[4]->image_path) }}" style="width:100%; height:100%; object-fit:cover; display:block;">
                            </div>
                            <div style="background:#1a459c; border-radius:0 0 6px 6px; padding:6px 12px;">
                                <div style="font-size:10px; font-weight:bold; color:#fff; font-family:'Poppins',sans-serif; text-transform:uppercase;">{{ $imgs[4]->place ?? '' }}</div>
                            </div>
                            @if(!empty($imgs[4]->description))
                            <div style="padding:5px 2px; font-size:9px; color:#555; line-height:1.5;">{{ Str::words($imgs[4]->description, 10) }}</div>
                            @endif
                        </div>
                        @endif
                    </td>
                </tr>
            </table>
            @endif

        </div>
    @endforeach
@endif

</body>
</html>