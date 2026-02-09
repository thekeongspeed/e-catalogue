<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Katalog {{ $name }}</title>
    <style>
        /* RESET & FONT */
        @page { margin: 0px; } /* Hilangkan margin default PDF agar warna mentok tepi */
        body { margin: 0px; font-family: 'Helvetica', 'Arial', sans-serif; }
        
       /* --- UPDATE COVER PAGE STYLES --- */
        .cover-page {
            position: relative;
            width: 100%;
            height: 1120px; /* Ganti 100vh jadi Pixel pasti (A4) */
            background: white;
            /* overflow: hidden; <-- HAPUS INI */
            z-index: 0;
        }

        /* Shape Abu Kanan Atas */
        .shape-top-right {
            position: absolute;
            top: 0;
            right: 0;
            width: 70%;
            height: 300px; /* Sedikit diperbesar */
            background-color: #e6e7e9; 
            border-bottom-left-radius: 200px 150px; /* Lengkungan lebih halus */
            z-index: 1;
        }

        /* Shape Biru Kiri */
        .shape-blue-left {
            position: absolute;
            top: 450px;
            left: -50px;
            width: 400px;
            height: 100px;
            background-color: #003399;
            transform: rotate(-45deg); /* Sudut diubah dikit biar aman */
            z-index: 1;
            border-radius: 0 50px 50px 0;
        }

        /* Gambar Produk Utama */
        .cover-main-image {
            position: absolute;
            top: 250px; /* Posisi diturunkan */
            left: 50px;
            right: 50px;
            height: 500px;
            text-align: center;
            z-index: 5; /* Z-Index ditinggikan */
        }
        
        /* Pastikan gambar tidak melebar */
        .cover-main-image img {
            height: 100%;
            width: auto;
            max-width: 100%;
            object-fit: contain;
        }

        /* 4. Tipografi Bawah Kiri */
        .cover-footer {
            position: absolute;
            bottom: 50px;
            left: 50px;
            z-index: 3;
        }
        
        .title-big {
            font-size: 80px;
            font-weight: 900;
            color: #003399; /* Biru */
            line-height: 0.9;
            margin: 0;
            text-transform: uppercase;
        }
        
        .title-sub {
            font-size: 38px;
            font-weight: 800;
            color: #222; /* Hitam/Abu gelap */
            margin: 5px 0 0 0;
            text-transform: uppercase;
            letter-spacing: -1px;
        }

        .title-underline {
            display: block;
            width: 120px;
            height: 10px;
            background-color: #003399;
            margin-top: 20px;
            border-radius: 2px;
        }
        
        .client-name {
            margin-top: 15px;
            font-size: 16px;
            color: #666;
            font-weight: bold;
        }

        /* --- CONTENT PAGE STYLES (Halaman Berikutnya) --- */
        .content-wrapper { padding: 40px; } /* Padding untuk halaman isi */
        .page-break { page-break-after: always; }

        .header { border-bottom: 2px solid #1a459c; padding-bottom: 10px; margin-bottom: 20px; margin-top: 20px; }
        .header h1 { color: #1a459c; margin: 0; font-size: 24px; text-transform: uppercase; }
        .header span { font-size: 14px; color: #666; }
        
        .content-image { width: 100%; height: 350px; object-fit: contain; margin-bottom: 20px; border: 1px solid #eee; background: #f9f9f9; text-align: center; }
        .content-image img { max-height: 100%; max-width: 100%; }

        .spec-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 13px; }
        .spec-table th, .spec-table td { border: 1px solid #ddd; padding: 6px 10px; }
        .spec-table th { background-color: #f0f4f8; text-align: left; color: #1a459c; width: 35%; }
        
        .section-title { background-color: #1a459c; color: white; padding: 6px 15px; font-size: 14px; font-weight: bold; margin-bottom: 15px; border-radius: 4px; }

        .part-container { width: 100%; border-bottom: 1px solid #eee; padding: 10px 0; }
        .part-table { width: 100%; }
        .part-img-cell { width: 100px; vertical-align: top; }
        .part-img { width: 80px; height: 80px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px; }
        .part-info-cell { vertical-align: top; padding-left: 15px; }
        .part-name { font-size: 13px; font-weight: bold; color: #000; margin-bottom: 3px; display: block; }
        .part-detail { font-size: 11px; color: #555; line-height: 1.4; }

        .project-grid { width: 100%; }
        .project-cell { width: 48%; display: inline-block; vertical-align: top; margin-bottom: 20px; margin-right: 2%; }
        .project-img { width: 100%; height: 180px; object-fit: cover; border: 1px solid #ddd; }
        .project-loc { font-size: 11px; font-weight: bold; color: #555; text-align: center; margin-top: 5px;}
    </style>
</head>
<body>
<div class="cover-page">
        
        <div class="shape-top-right"></div>
        <div class="shape-blue-left"></div>
        
        <div class="cover-logo">
            <h2 style="color:#003399; margin:0; font-size: 30px;">E-CATALOGUE</h2>
            <small style="color:#555; font-size: 14px;">Official Document</small>
        </div>

        <div class="cover-main-image">
            @if(isset($data) && count($data) > 0)
                @php
                    // Ambil produk pertama yang punya gambar
                    $firstProductWithImage = collect($data)->first(function ($item) {
                        return $item['gallery']->isNotEmpty();
                    });
                @endphp

                @if($firstProductWithImage)
                    <img src="{{ public_path('storage/' . $firstProductWithImage['gallery']->first()->image_path) }}">
                @else
                    <div style="margin-top:200px; color:red; font-weight:bold; border:1px dashed red; padding:20px;">
                        [DEBUG: Data Ada, Tapi Tidak Ada Gambar di Gallery]
                    </div>
                @endif
            @else
                <div style="margin-top:200px; color:red; font-weight:bold; border:1px dashed red; padding:20px;">
                    [DEBUG: Variable $data KOSONG]
                </div>
            @endif
        </div>

        <div class="cover-footer">
            <div class="title-big">{{ Str::upper(Str::limit($name, 15)) }}</div> 
            <div class="title-sub">SERIES CATALOGUE</div>
            <div class="title-underline"></div>
            <div class="client-name">Prepared for: {{ $name }}</div>
        </div>
    </div>

    <div class="page-break"></div>


    <div class="content-wrapper">
        @foreach($data as $d)
            @php 
                $product = $d['product'];
                $gallery = $d['gallery'];
                $items   = $d['items'];
                $projects= $d['projects'];
            @endphp

            <div class="header">
                <h1>{{ $product->nama_barang }}</h1>
                <span>Specification Details</span>
            </div>

            <div class="content-image">
                @if($gallery->isNotEmpty())
                    <img src="{{ public_path('storage/' . $gallery->first()->image_path) }}">
                @else
                    <div style="padding-top: 150px; color: #ccc;">No Image Available</div>
                @endif
            </div>

            <div class="section-title">Technical Specification</div>
            <table class="spec-table">
                <tr><th>Product Name</th><td>{{ $product->nama_barang }}</td></tr>
                <tr><th>Material</th><td>{{ $product->jenis_material ?? '-' }}</td></tr>
                <tr><th>Finishing</th><td>{{ $product->finishing ?? '-' }}</td></tr>
                <tr><th colspan="2" style="background-color: #e9ecef; text-align: center; font-size: 10px;">DIMENSION (mm)</th></tr>
                <tr><th>Panjang</th><td>{{ $product->panjang }} mm</td></tr>
                <tr><th>Lebar</th><td>{{ $product->lebar }} mm</td></tr>
                <tr><th>Tinggi</th><td>{{ $product->tinggi }} mm</td></tr>
                @if($product->kedalaman) <tr><th>Kedalaman</th><td>{{ $product->kedalaman }} mm</td></tr> @endif
            </table>

            <div class="section-title" style="margin-top: 20px;">Component Parts</div>
            @if($items->isEmpty())
                <p style="text-align: center; color: #888; font-size: 12px;">- No components -</p>
            @else
                @foreach($items as $item)
                <div class="part-container">
                    <table class="part-table">
                        <tr>
                            <td class="part-img-cell">
                                @if($item->foto_item)
                                    <img src="{{ public_path('storage/' . $item->foto_item) }}" class="part-img">
                                @else
                                    <div class="part-img" style="background: #eee; font-size: 9px; line-height: 80px; text-align: center;">No Pic</div>
                                @endif
                            </td>
                            <td class="part-info-cell">
                                <span class="part-name">{{ $item->nama_item }}</span>
                                <div class="part-detail">
                                    Type: {{ $item->tipe ?? '-' }} <br>
                                    Dim: {{ $item->dimensi_part ?? '-' }} | Load: {{ $item->load_capacity ?? '-' }}
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                @endforeach
            @endif

            @if($projects->isNotEmpty())
                <div class="page-break"></div> <div class="header">
                    <h1>Project Reference</h1>
                    <span>Implementation Gallery</span>
                </div>
                <div class="project-grid">
                    @foreach($projects as $proj)
                    <div class="project-cell">
                        <div style="border:1px solid #eee; height:180px; overflow:hidden;">
                            <img src="{{ public_path('storage/' . $proj->image_path) }}" class="project-img">
                        </div>
                        <div class="project-loc">📍 {{ $proj->place ?? 'Location' }}</div>
                    </div>
                    @endforeach
                </div>
            @endif

            @if(!$loop->last)
                <div class="page-break"></div>
            @endif

        @endforeach
    </div>

</body>
</html>