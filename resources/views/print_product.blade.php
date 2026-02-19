<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->nama_barang }}</title>
    <style>
        /* --- 1. DEKLARASI FONT LOKAL: MONTSERRAT --- */
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
            background: #fff;
            counter-reset: page; 
        }
        
        .page-break { page-break-after: always; height: 0; margin: 0; padding: 0; border: none; display: block; clear: both; visibility: hidden; }
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
        .page-header { margin: 40px 40px 20px 40px; }
        .ph-title { font-size: 26px; font-weight: bold; color: #1a459c; text-transform: uppercase; margin: 0; line-height: 1.2; }
        .ph-subtitle { font-size: 15px; font-weight: normal; color: #666; text-transform: uppercase; margin-top: 5px; }
        .ph-line { width: 100%; height: 2px; background-color: #eaeaea; margin-top: 15px; }

        /* --- HALAMAN 1: COVER --- */
        .cover-page { position: relative; 
            width: 100%; 
            height: 1000px; /* DIKURANGI AGAR TIDAK MUNCUL HALAMAN KOSONG */
            background: #fff;  }
        .cover-sidebar {  position: absolute; 
            top: -60px;     /* WAJIB PAKAI px */
            height: 1500px;  /* WAJIB PAKAI px, ditarik tembus margin bawah */
            left: -60px;    /* WAJIB PAKAI px, ditarik tembus margin kiri */
            width: 30%; 
            background-color: #1a459c; 
            z-index: -1;  }
        .cover-content { position: absolute; top: 80px; left: 25%; right: 40px; z-index: 2; }
        
        .cover-title-customer { font-size: 45px; font-weight: 800; color: #4e4e4e; line-height: 1.1; text-transform: uppercase; margin-bottom: 20px; }
        .cover-title { font-size: 38px; font-weight: 800; color: #0d2c6b; line-height: 1.1; text-transform: uppercase; margin-bottom: 40px; padding-bottom: 15px; border-bottom: 4px solid #1a459c; display: inline-block; }

        .cover-image { width: 100%; height: 450px; background: #fafafa; border-radius: 8px; text-align: center; margin-bottom: 40px; display: flex; align-items: center; justify-content: center; }
        .cover-image img { max-height: 95%; max-width: 95%; width: auto; height: auto; object-fit: contain; padding-top: 2.5%; }

        .cover-footer { text-align: right; margin-top: 40px; }
        .cover-slogan { font-size: 20px; font-weight: bold; color: #333; }

        /* --- HALAMAN 2: SPESIFIKASI --- */
        .spec-container { padding: 0 40px; }
        .product-info { margin-bottom: 30px; }
        .product-info table { width: 100%; font-size: 13px; border-collapse: collapse; }
        .product-info td { padding: 8px 0; border-bottom: 1px dashed #eee; }
        .product-info .label { font-weight: bold; width: 140px; color: #666; }
        .product-info .value { font-weight: bold; color: #222; }

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
        
        .part-img-box { width: 100%; height: 160px; line-height: 160px; text-align: center; border: 1px solid #eee; background: #fafafa; margin-bottom: 10px; border-radius: 4px; overflow: hidden; }
        .part-img-box img { vertical-align: middle; max-width: 90%; max-height: 90%; width: auto; height: auto; }
        
        .part-detail-table { width: 100%; font-size: 12px; }
        .part-detail-table td { padding: 4px 0; vertical-align: top; border-bottom: 1px solid #f5f5f5; }
        .pd-label { width: 40%; color: #666; }
        .pd-val { width: 60%; font-weight: bold; color: #222; }

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
            
            /* INI KUNCINYA: */
            /* Jangan pakai width: 100% */
            /* Gunakan margin untuk memberi jarak dari pinggir kertas */
            margin-left: 40px;
            margin-right: 40px;
            margin-top: 20px;
            margin-bottom: 20px; 
        }

        /* Style Header agar ikut margin wrapper */
        .project-header-clean {
            border-bottom: 2px solid #ddd;
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



    </style>
</head>
<body>

    <div class="footer-page">
        <div class="footer-line"></div>
        <span class="page-num"></span>
    </div>

    <div class="cover-page">
        <div class="cover-sidebar"></div>
        <div class="cover-content">
            <div class="cover-title-customer">
                {{ $product->nama_customer }}
            </div>

            <div class="cover-title">
                {{ strtoupper($product->nama_barang) }}<br>SPECIFICATION
            </div>

            <div class="cover-image">
                 @if($gallery->isNotEmpty())
                    <img src="{{ public_path('storage/' . $gallery->first()->image_path) }}">
                @else
                    <div style="color:#ccc; font-style:italic;">No Cover Image Available</div>
                @endif
            </div>

            <div class="cover-footer">
                <div class="cover-slogan">
                    <span style="font-size: 16px; font-weight:normal; color:#666;">Smart Solution for Better Life</span>
                </div>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="page-header">
        <h1 class="ph-title">{{ $product->nama_barang }}</h1>
        <h2 class="ph-subtitle">TECHNICAL SPECIFICATION</h2>
        <div class="ph-line"></div>
    </div>

    <div class="spec-container">
        <div style="text-align: center; height: 300px; margin-bottom: 30px; border-bottom: 1px solid #f0f0f0; padding-bottom: 15px;">
            @if($gallery->isNotEmpty())
                <img src="{{ public_path('storage/' . $gallery->first()->image_path) }}" style="max-height: 100%; max-width: 100%; object-fit: contain;">
            @else
                <div style="padding-top:130px; color:#ccc; font-style:italic;">No Image Available</div>
            @endif
        </div>

      <div class="product-info avoid-break">
        <table>
            <tr>
                <td class="label">Material</td>
                <td class="value">: {{ $product->jenis_material }}</td>
            </tr>
            <tr>
                <td class="label">Finishing</td>
                <td class="value">: {{ $product->finishing }}</td>
            </tr>
            <tr>
                <td class="label">Color Available</td>
                <td class="value">: <span style="color: #000102;">{{ $product->color_available ?? '-' }}</span></td>
            </tr>
            <tr>
                <td class="label">Est. Price</td>
                <td class="value" style="color: #001104;">: Rp {{ number_format($product->price, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div class="specs-container avoid-break">
        <div class="section-title">Dimension Details</div>
        <table class="dim-table">
            <thead>
                <tr>
                    <th>Item Code</th> 
                    <th>Panjang (L)</th>
                    <th>Lebar (W)</th>
                    <th>Tinggi (H)</th>
                    <th>Kedalaman (D)</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($dimensions) && count($dimensions) > 0)
                    @foreach($dimensions as $dim)
                    <tr>
                        <td style="font-weight: bold; color: #1a459c;">{{ $dim->item_code ?? '-' }}</td>
                        <td>{{ floatval($dim->panjang) }}</td>
                        <td>{{ floatval($dim->lebar) }}</td>
                        <td>{{ floatval($dim->tinggi) }}</td>
                        <td>{{ floatval($dim->kedalaman) }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr><td colspan="5" style="padding: 15px; font-style: italic; color: #999;">- Data dimensi tidak tersedia -</td></tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    <div class="page-header">
        <h1 class="ph-title">{{ $product->nama_barang }}</h1>
        <h2 class="ph-subtitle">COMPONENT PARTS</h2>
        <div class="ph-line"></div>
    </div>

    <div class="parts-grid">
        @if($items->isEmpty())
            <div style="text-align:center; color:#999; padding: 40px 0; font-style: italic;">- No component parts available -</div>
        @else
            @foreach($items as $item)
            <div class="part-item avoid-break">
                <div class="part-title">{{ $item->nama_item }}</div>
                
                <div class="part-img-box">
                    @if($item->foto_item)
                        <img src="{{ public_path('storage/' . $item->foto_item) }}">
                    @else
                        <span style="color:#ccc; font-style:italic;">No Image</span>
                    @endif
                </div>

                <table class="part-detail-table">
                    <tr>
                        <td class="pd-label">Type/Series</td>
                        <td class="pd-val">: {{ $item->tipe ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="pd-label">Dimensions</td>
                        <td class="pd-val">: {{ $item->dimensi_part ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="pd-label">Configuration</td>
                        <td class="pd-val">: {{ $item->konfigurasi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="pd-label">Load Capacity</td>
                        <td class="pd-val">: {{ $item->load_capacity ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            @endforeach
        @endif
    </div>



  @if(count($projects) > 0)
                @foreach($projects->chunk(6) as $chunk)
                    @php $imgs = $chunk->values(); @endphp

                    <div class="project-page-fixed">
                        
                        <div class="project-header-clean">
                            <h1 class="ph-title">{{ $product->nama_barang }}</h1>
                            <h2 class="ph-subtitle">Project References</h2>
                            <div class="ph-line"></div>
                        </div>

                        <table class="grid-table">
                            <tr>
                                <td width="60%" rowspan="2" style="padding: 0; vertical-align: top;">
                                    @if(isset($imgs[0]))
                                    <div class="grid-box" style="height: 360px; background-image: url('{{ public_path('storage/' . $imgs[0]->image_path) }}');">
                                        <div class="grid-label">{{ $imgs[0]->place ?? '' }}</div>
                                    </div>
                                    @endif
                                </td>
                                <td width="40%" style="padding: 0; vertical-align: top;">
                                    @if(isset($imgs[1]))
                                    <div class="grid-box" style="height: 175px; background-image: url('{{ public_path('storage/' . $imgs[1]->image_path) }}');">
                                        <div class="grid-label">{{ $imgs[1]->place ?? '' }}</div>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 0; vertical-align: bottom;">
                                    @if(isset($imgs[2]))
                                    <div class="grid-box" style="height: 175px; background-image: url('{{ public_path('storage/' . $imgs[2]->image_path) }}');">
                                        <div class="grid-label">{{ $imgs[2]->place ?? '' }}</div>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        </table>

                        @if(isset($imgs[3]))
                        <table class="grid-table" style="margin-top: 10px;">
                            <tr>
                                <td style="padding: 0;">
                                    <div class="grid-box" style="height: 220px; background-image: url('{{ public_path('storage/' . $imgs[3]->image_path) }}');">
                                        <div class="grid-label">{{ $imgs[3]->place ?? '' }}</div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        @endif

                        @if(isset($imgs[4]) || isset($imgs[5]))
                        <table class="grid-table" style="margin-top: 10px;">
                            <tr>
                                <td width="50%" style="padding: 0;">
                                    @if(isset($imgs[4]))
                                    <div class="grid-box" style="height: 220px; background-image: url('{{ public_path('storage/' . $imgs[4]->image_path) }}');">
                                        <div class="grid-label">{{ $imgs[4]->place ?? '' }}</div>
                                    </div>
                                    @endif
                                </td>
                                <td width="50%" style="padding: 0;">
                                    @if(isset($imgs[5]))
                                    <div class="grid-box" style="height: 220px; background-image: url('{{ public_path('storage/' . $imgs[5]->image_path) }}');">
                                        <div class="grid-label">{{ $imgs[5]->place ?? '' }}</div>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        </table>
                        @endif


                    </div> @endforeach
            @endif


    



</body>
</html>