<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Katalog - {{ $name }}</title>
    <style>
        /* --- 1. RESET & SETUP --- */
        @page { margin: 0px; }
        body { 
            margin: 0px; 
            padding: 0px;
            font-family: 'Helvetica', 'Arial', sans-serif; 
            color: #000;
            background: #fff;
            counter-reset: page; /* Reset penghitung halaman */
        }
        
        /* Page Break Aman */
        .page-break { 
            page-break-after: always; 
            height: 0; 
            display: block; 
            clear: both;
            visibility: hidden;
        }

        /* --- 2. LAYOUT UTAMA (MAIN COVER) --- */
        .main-cover {
            position: relative;
            width: 100%;
            height: 1120px;
            overflow: hidden; 
            background: #fff;
        }
        .mc-sidebar {
            position: absolute; top: 0; bottom: 0; left: 0;
            width: 30%; background-color: #1a459c; z-index: 1;
        }
        .mc-content {
            position: absolute; top: 35%; left: 35%; right: 5%; z-index: 2;
        }
        .mc-title {
            font-size: 50px; font-weight: 800; color: #1a459c;
            line-height: 1; margin-bottom: 15px; text-transform: uppercase;
        }
        .mc-subtitle {
            font-size: 24px; color: #555; letter-spacing: 2px;
            text-transform: uppercase; font-weight: normal;
        }
        .mc-footer {
            position: absolute; bottom: 50px; left: 35%;
            font-size: 14px; color: #999;
        }

        /* --- 3. PEMBATAS BARANG (PRODUCT COVER) --- */
        .prod-cover {
            position: relative;
            width: 100%;
            height: 1120px;
            overflow: hidden;
            background: #fff;
        }
        .prod-sidebar {
            position: absolute; top: 0; bottom: 0; left: 0;
            width: 15%; background-color: #1a459c; 
        }
        .prod-content {
            position: absolute; top: 100px; left: 20%; right: 40px;
        }
        .prod-title {
            font-size: 40px; font-weight: 800; color: #0d2c6b;
            text-transform: uppercase; border-bottom: 5px solid #1a459c;
            padding-bottom: 20px; margin-bottom: 40px; display: inline-block;
        }
        .prod-img-box {
            width: 100%; height: 450px; text-align: center;
            margin-bottom: 40px; display: block;
        }
        .prod-img-box img {
            max-width: 100%; max-height: 100%; width: auto; height: auto;
            object-fit: contain;
        }

        /* --- 4. CSS COUNTER (NOMOR HALAMAN) --- */
        .footer-page {
            position: fixed; bottom: 30px; right: 40px;
            text-align: right; z-index: 999;
        }
        .footer-line { width: 50px; height: 3px; background: #1a459c; margin-left: auto; margin-bottom: 5px; }
        .page-num:after { content: counter(page); font-weight: bold; font-size: 12px; }

        /* --- 5. HEADER HALAMAN ISI --- */
        .page-header { margin: 40px 40px 20px 40px; }
        .ph-title { font-size: 28px; font-weight: bold; color: #1a459c; text-transform: uppercase; margin: 0; }
        .ph-subtitle { font-size: 16px; color: #666; text-transform: uppercase; margin-top: 5px; }
        .ph-line { width: 100%; height: 2px; background: #eee; margin-top: 10px; }
        .container-content { padding: 0 40px; }

        /* --- 6. STYLE BARU: SPESIFIKASI BESAR & BERSIH --- */
        .spec-img-container {
            width: 100%;
            height: 500px; /* Gambar diperbesar */
            text-align: center;
            margin-bottom: 30px;
            display: block;
            border-bottom: 1px solid #f0f0f0;
        }
        .spec-img-container img {
            max-height: 95%; max-width: 100%; width: auto; height: auto;
            object-fit: contain;
        }

        /* Info Table Layout */
        .info-table { width: 100%; margin-bottom: 30px; border-collapse: collapse; }
        .info-table td { vertical-align: top; padding: 10px; }
        
        .spec-item-title {
            font-size: 11px; text-transform: uppercase; color: #888;
            font-weight: bold; letter-spacing: 1px; margin-bottom: 5px;
        }
        .spec-item-value {
            font-size: 16px; color: #000; font-weight: 500;
            margin-bottom: 20px; border-left: 3px solid #1a459c; padding-left: 10px;
        }

        /* List Warna */
        .color-dots { margin: 0; padding: 0; list-style: none; }
        .color-dots li {
            margin-bottom: 8px; font-size: 14px; display: block;
            position: relative; padding-left: 20px;
        }
        .color-dots li::before {
            content: ""; position: absolute; left: 0; top: 4px;
            width: 10px; height: 10px; background-color: #1a459c; border-radius: 50%;
        }

        /* Tabel Dimensi Modern */
        .dim-table-modern {
            width: 100%; border-collapse: collapse; font-size: 13px;
            border: 1px solid #e0e0e0;
        }
        .dim-table-modern th {
            background-color: #1a459c; color: white;
            padding: 12px 15px; text-align: center; font-weight: bold;
            text-transform: uppercase; font-size: 12px;
        }
        .dim-table-modern td {
            padding: 12px 15px; text-align: center;
            border-bottom: 1px solid #eee; color: #333;
        }
        .dim-table-modern tr:nth-child(even) { background-color: #f9f9f9; }


        /* --- 7. PARTS GRID --- */
        .parts-wrapper { width: 100%; font-size: 0; }
        .part-box {
            width: 48%; display: inline-block; vertical-align: top;
            margin-bottom: 40px; margin-right: 2%; font-size: 12px;
        }
        .part-img-container {
            width: 100%; height: 140px; line-height: 140px;
            text-align: center; border: 1px solid #eee; background: #fafafa;
            margin-bottom: 10px;
        }
        .part-img-container img {
            vertical-align: middle; max-width: 90%; max-height: 90%;
            width: auto; height: auto;
        }
        .tbl-part { width: 100%; font-size: 11px; }
        .tbl-part td { padding: 3px 0; vertical-align: top; }

        /* --- 8. PROJECTS --- */
        .proj-hero { width: 100%; height: 300px; object-fit: cover; margin-bottom: 10px; background: #eee; }
        .proj-thumb { width: 32%; height: 120px; object-fit: cover; display: inline-block; margin-right: 1%; background: #eee; margin-bottom: 10px; }

    </style>
</head>
<body>

    <div class="main-cover">
        <div class="mc-sidebar"></div>
        <div class="mc-content">
            <div class="mc-title">{{ strtoupper($name) }}<br>CATALOGUE</div>
            <div class="mc-subtitle">Official Product Document</div>
        </div>
        <div class="mc-footer">Generated on {{ date('d F Y') }}</div>
    </div>
    
    <div class="footer-page">
        <div class="footer-line"></div>
        <span class="page-num"></span>
    </div>

    <div class="page-break"></div>

    @foreach($data as $d)
        @php 
            $product = $d['product'];
            $gallery = $d['gallery'];
            $items   = $d['items'];
            $projects= $d['projects'];
            $dimensions = $d['dimensions'];
        @endphp

        <div class="prod-cover">
            <div class="prod-sidebar"></div>
            <div class="prod-content">
                <div style="font-size: 14px; color: #666; margin-bottom: 5px;">PRODUCT DETAILS</div>
                <div class="prod-title">{{ $product->nama_barang }}</div>

                <div class="prod-img-box">
                    @if($gallery->isNotEmpty())
                        <img src="{{ public_path('storage/' . $gallery->first()->image_path) }}">
                    @else
                        <div style="padding-top:150px; color:#ccc;">No Cover Image</div>
                    @endif
                </div>

                <div>
                    <strong>Category:</strong> {{ $product->nama_customer }}<br>
                    <strong>Type:</strong> {{ $product->tipe ?? 'Standard' }}
                </div>
            </div>
        </div>
        
        <div class="page-break"></div>

        <div class="page-header">
            <h1 class="ph-title">{{ $product->nama_barang }}</h1>
            <h2 class="ph-subtitle">Technical Specification</h2>
            <div class="ph-line"></div>
        </div>

        <div class="container-content">
            <div class="spec-img-container">
                @if($gallery->isNotEmpty())
                    <img src="{{ public_path('storage/' . $gallery->first()->image_path) }}">
                @else
                    <div style="padding-top:200px; color:#ccc; font-style:italic;">No Image Available</div>
                @endif
            </div>

            <table class="info-table">
                <tr>
                    <td width="60%">
                        <div class="spec-item-title">Base Material</div>
                        <div class="spec-item-value">{{ $product->jenis_material ?? '-' }}</div>

                        <div class="spec-item-title">Finishing / Layer</div>
                        <div class="spec-item-value">{{ $product->finishing ?? '-' }}</div>

                        <div class="spec-item-title">Product Type</div>
                        <div class="spec-item-value">{{ $product->tipe ?? '-' }}</div>
                    </td>
                    <td width="40%" style="background-color: #fcfcfc; border-radius: 8px;">
                        <div class="spec-item-title" style="margin-bottom: 15px; color: #1a459c;">Available Colors</div>
                        <ul class="color-dots">
                            <li>White Satin</li>
                            <li>Black Satin</li>
                            <li>Wood Grain (Optional)</li>
                        </ul>
                    </td>
                </tr>
            </table>

            <div style="margin-top: 10px;">
                <div class="spec-item-title" style="margin-bottom: 10px;">Dimension Details (mm)</div>
                <table class="dim-table-modern">
                    <thead>
                        <tr>
                            <th>Panjang (L)</th>
                            <th>Lebar (W)</th>
                            <th>Tinggi (H)</th>
                            <th>Kedalaman (D)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($dimensions->isEmpty())
                            <tr>
                                <td colspan="4" style="font-style: italic; color: #999;">
                                    - Data dimensi tidak tersedia -
                                </td>
                            </tr>
                        @else
                            @foreach($dimensions as $dim)
                            <tr>
                                <td><strong>{{ floatval($dim->panjang) }}</strong></td>
                                <td><strong>{{ floatval($dim->lebar) }}</strong></td>
                                <td><strong>{{ floatval($dim->tinggi) }}</strong></td>
                                <td><strong>{{ floatval($dim->kedalaman) }}</strong></td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

        <div class="page-break"></div>

        <div class="page-header">
            <h1 class="ph-title">{{ $product->nama_barang }}</h1>
            <h2 class="ph-subtitle">Component Parts</h2>
            <div class="ph-line"></div>
        </div>

        <div class="container-content parts-wrapper">
            @if($items->isEmpty())
                <p style="text-align:center; color:#999;">- No parts available -</p>
            @else
                @foreach($items as $item)
                <div class="part-box">
                    <div style="font-weight:bold; margin-bottom:5px; height:18px; overflow:hidden;">
                        {{ $item->nama_item }}
                    </div>
                    
                    <div class="part-img-container">
                        @if($item->foto_item)
                            <img src="{{ public_path('storage/' . $item->foto_item) }}">
                        @else
                            <span style="color:#ccc;">No Image</span>
                        @endif
                    </div>

                    <table class="tbl-part">
                        <tr><td width="40%"><strong>Type</strong></td><td>{{ $item->tipe ?? '-' }}</td></tr>
                        <tr><td><strong>Dim</strong></td><td>{{ $item->dimensi_part ?? '-' }}</td></tr>
                        <tr><td><strong>Load</strong></td><td>{{ $item->load_capacity ?? '-' }}</td></tr>
                    </table>
                </div>
                @endforeach
            @endif
        </div>

        @if($projects->isNotEmpty())
            <div class="page-break"></div>
            
            <div class="page-header">
                <h1 class="ph-title">{{ $product->nama_barang }}</h1>
                <h2 class="ph-subtitle">Project References</h2>
                <div class="ph-line"></div>
            </div>

            <div class="container-content">
                <img src="{{ public_path('storage/' . $projects->first()->image_path) }}" class="proj-hero">
                
                @foreach($projects->skip(1) as $proj)
                    <img src="{{ public_path('storage/' . $proj->image_path) }}" class="proj-thumb">
                @endforeach
            </div>
        @endif

        @if(!$loop->last)
            <div class="page-break"></div>
        @endif

    @endforeach

</body>
</html>