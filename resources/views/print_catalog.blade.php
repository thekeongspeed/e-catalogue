<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Katalog - {{ $name }}</title>

<style>

    @font-face {
        font-family: 'Poppins';
        font-style: normal;
        font-weight: normal;
        src: url("{{ public_path('fonts/Poppins-Regular.ttf') }}") format('truetype');
    }

    @font-face {
        font-family: 'Poppins';
        font-style: normal;
        font-weight: 800; /* Khusus untuk Catalogue / Judul */
        src: url("{{ public_path('fonts/Poppins-Bold.ttf') }}") format('truetype');
    }

    @font-face {
        font-family: 'Montserrat';
        font-style: normal;
        font-weight: normal; /* 400 */
        src: url("{{ public_path('fonts/Montserrat-Regular.ttf') }}") format('truetype');
    }

    @font-face {
        font-family: 'Montserrat';
        font-style: normal;
        font-weight: bold; /* 700 */
        src: url("{{ public_path('fonts/Montserrat-Bold.ttf') }}") format('truetype');
    }

        /* --- 1. RESET & SETUP --- */
        @page { margin: 0px; }
        body { 
            margin: 0px; padding: 0px;
            font-family:  'Montserrat','Arial', sans-serif; 
            color: #333; /* Warna abu gelap agar lebih nyaman di mata (tidak pure black) */
            background: #fff;
            counter-reset: page; 
        }
        

        .mc-title, .mc-subtitle, 
        .prod-title, .toc-title, .toc-table th, 
        .ph-title, .spec-item-title, .dim-table-modern th,
        .part-title {
            font-family: 'Poppins', sans-serif ;
        }


        /* Page Break Aman */
        .page-break { page-break-after: always; height: 0; margin: 0; padding: 0;  border: none; display: block; clear: both; visibility: hidden; }
        .avoid-break { page-break-inside: avoid; } /* Mencegah elemen terpotong setengah halaman */

        /* --- 2. LAYOUT UTAMA (MAIN COVER) --- */
        .main-cover { 
            position: relative; 
            width: 100%; 
            height: 1000px; /* DIKURANGI AGAR TIDAK MUNCUL HALAMAN KOSONG */
            overflow: hidden; 
            background: #fff; 
        }
        .mc-sidebar { 
            position: absolute; 
            top: -60px;     /* WAJIB PAKAI px */
            bottom: -60px;  /* WAJIB PAKAI px, ditarik tembus margin bawah */
            left: -60px;    /* WAJIB PAKAI px, ditarik tembus margin kiri */
            width: 30%; 
            background-color: #1a459c; 
            z-index: -1; 
        }
        .mc-content { position: absolute; top: 35%; left: 35%; right: 5%; z-index: 2; }
        .mc-title { font-size: 50px; font-weight: 800; color: #1a459c; line-height: 1.1; margin-bottom: 15px; text-transform: uppercase; }
        .mc-subtitle { font-size: 22px; color: #666; letter-spacing: 2px; text-transform: uppercase; font-weight: normal; }
        .mc-footer { position: absolute; bottom: 50px; left: 35%; font-size: 14px; color: #999; }

        /* --- 3. PEMBATAS BARANG (PRODUCT COVER) --- */
        .prod-cover { 
            position: relative; 
            width: 100%; 
            height: 1000px;  
            background: #fff; 
        }
        .prod-sidebar { 
            position: absolute; 
            top: -100px;    
            height: 1500px;   /* Tarik jauh ke bawah melewati batas kertas */
            left: -100px;   /* WAJIB PAKAI px */
            width: 20%; 
            background-color: #1a459c; 
            z-index: -1;
        }
        .prod-content { position: absolute; top: 120px; left: 20%; right: 40px; }
        .prod-title { 
            font-size: 38px; font-weight: 800; color: #0d2c6b; text-transform: uppercase; 
            border-bottom: 4px solid #1a459c; padding-bottom: 15px; margin-bottom: 30px; display: inline-block; 
        }
        .prod-img-box { width: 100%; height: 450px; text-align: center; margin-bottom: 30px; display: block; background: #fafafa; border-radius: 8px;}
        .prod-img-box img { max-width: 95%; max-height: 95%; width: auto; height: auto; object-fit: contain; padding-top: 2.5%; }



        
        /* Badge untuk Kategori/Tipe */
        .badge { 
            display: inline-block; background: #f0f4fa; color: #1a459c; 
            padding: 8px 15px; border-radius: 4px; font-size: 14px; font-weight: bold; margin-right: 10px; border: 1px solid #d0deea;
        }

        /* --- 4. CSS COUNTER (NOMOR HALAMAN) --- */
        .footer-page { position: fixed; bottom: 30px; right: 40px; text-align: right; z-index: 999; }
        .footer-line { width: 50px; height: 3px; background: #1a459c; margin-left: auto; margin-bottom: 5px; }
        .page-num:after { content: counter(page); font-weight: bold; font-size: 12px; color: #666; }

        /* --- 5. HEADER HALAMAN ISI --- */
        .page-header { margin: 40px 40px 20px 40px; }
        .ph-title { font-size: 26px; font-weight: bold; color: #1a459c; text-transform: uppercase; margin: 0; }
        .ph-subtitle { font-size: 15px; color: #666; text-transform: uppercase; margin-top: 5px; }
        .ph-line { width: 100%; height: 2px; background: #eaeaea; margin-top: 15px; }
        .container-content { padding: 0 40px; }

        /* --- 6. SPESIFIKASI --- */
        .spec-img-container { width: 100%; height: 400px; text-align: center; margin-bottom: 30px; border-bottom: 1px solid #f0f0f0; }
        .spec-img-container img { max-height: 95%; max-width: 100%; width: auto; height: auto; object-fit: contain; }
        
        /* Tabel Info Utama */
        .info-table { width: 100%; font-size: 13px; margin-bottom: 30px; border-collapse: collapse; }
        .info-table td { padding: 8px 0; border-bottom: 1px dashed #eee; }
        .info-label { width: 140px; color: #666; font-weight: bold; }
        .info-value { font-weight: bold; color: #222; }

        .spec-item-title { font-size: 13px; text-transform: uppercase; color: #1a459c; font-weight: bold; letter-spacing: 1px; margin-bottom: 10px; }

        /* Tabel Dimensi Modern */
        .dim-table-modern { width: 100%; border-collapse: collapse; font-size: 12px; border: 1px solid #e0e0e0; margin-bottom: 30px; }
        .dim-table-modern th { background-color: #1a459c; color: white; padding: 10px 15px; text-align: center; font-weight: bold; text-transform: uppercase; }
        .dim-table-modern td { padding: 10px 15px; text-align: center; border-bottom: 1px solid #eee; color: #444; }
        .dim-table-modern tr:nth-child(even) { background-color: #f8fafd; }

        /* --- 7. PARTS GRID --- */
        .parts-wrapper { width: 100%; font-size: 0; }
        .part-box { width: 48%; display: inline-block; vertical-align: top; margin-bottom: 30px; margin-right: 2%; font-size: 12px; page-break-inside: avoid; }
        .part-img-container { width: 100%; height: 160px; line-height: 160px; text-align: center; border: 1px solid #eee; background: #fafafa; margin-bottom: 10px; border-radius: 4px; overflow: hidden; }
        .part-img-container img { vertical-align: middle; max-width: 90%; max-height: 90%; width: auto; height: auto; }
        .tbl-part { width: 100%; font-size: 12px; }
        .tbl-part td { padding: 4px 0; vertical-align: top; border-bottom: 1px solid #f5f5f5; }

        /* --- 8. PROJECTS --- */
        .proj-hero { width: 100%; height: 350px; object-fit: cover; margin-bottom: 10px; border-radius: 4px; }
        .proj-thumb { width: 32%; height: 130px; object-fit: cover; display: inline-block; margin-right: 1%; margin-bottom: 10px; border-radius: 4px; }

        /* --- 9. DAFTAR ISI --- */
        .toc-wrapper { width: 80%; margin: 60px auto; }
        .toc-title { text-align: center; font-size: 22px; font-weight: bold; color: #1a459c; text-transform: uppercase; margin-bottom: 30px; letter-spacing: 2px; }
        .toc-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .toc-table th { border-bottom: 2px solid #1a459c; font-weight: bold; color: #333; text-transform: uppercase; font-size: 12px; text-align: left; padding: 12px 5px; }
        .toc-table td { padding: 12px 5px; border-bottom: 1px dotted #ccc; }
        
        a.page-link-auto { text-decoration: none; color: #1a459c; font-weight: bold; font-size: 14px; display: inline-block; min-width: 20px; }
      a.page-link-auto::after { 
    content: target-counter(attr(href), page); 
}


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

    <div class="toc-wrapper">
        <div class="toc-title">Daftar Isi</div>
        <table class="toc-table">
            <thead>
                <tr>
                    <th width="8%" style="text-align: center;">No.</th>
                    <th width="77%">Nama Barang</th>
                    <th width="15%" style="text-align: center;">Halaman</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $index => $item)
                <tr>
                    <td style="text-align: center; color: #888;">{{ sprintf('%02d', $index + 1) }}.</td>
                    <td style="font-weight: bold; color: #333; font-family: 'Poppins', sans-serif;">{{ $item['product']->nama_barang }}</td>
                    <td style="text-align: center; font-weight: bold;">
                        <a href="#product-{{ $item['product']->id }}" class="page-link-auto">Lihat </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

   @foreach($data as $index => $item)
        @php 
            $product = $item['product'];
            $gallery = $item['gallery'];
            $dimensions = $item['dimensions'];
            $items = $item['items'];
            $projects = $item['projects'];
        @endphp

        <div id="product-{{ $product->id }}">
            
            <a name="product-{{ $product->id }}"></a>
            <div class="prod-cover">
                <div class="prod-sidebar"></div>
                <div class="prod-content">
                    <div style="font-size: 14px; color: #888; margin-bottom: 5px; font-weight: bold; letter-spacing: 1px;">PRODUCT DETAILS</div>
                    <div class="prod-title">{{ $product->nama_barang }}</div>

                    <div class="prod-img-box">
                        @if($gallery->isNotEmpty())
                            <img src="{{ public_path('storage/' . $gallery->first()->image_path) }}">
                        @else
                            <div style="padding-top:200px; color:#ccc; font-style:italic;">No Cover Image Available</div>
                        @endif
                    </div>

                    <div>
                        <span class="badge">CATEGORY: {{ strtoupper($product->nama_customer) }}</span>
                        <span class="badge">TYPE: {{ strtoupper($product->tipe ?? 'STANDARD') }}</span>
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
                        <div style="padding-top:180px; color:#ccc; font-style:italic;">No Image Available</div>
                    @endif
                </div>

                <table class="info-table avoid-break">
                    <tr><td class="info-label">Base Material</td><td class="info-value">: {{ $product->jenis_material ?? '-' }}</td></tr>
                    <tr><td class="info-label">Finishing</td><td class="info-value">: {{ $product->finishing ?? '-' }}</td></tr>
                    <tr><td class="info-label">Color Available</td><td class="info-value">: <span style="color: #000309;">{{ $product->color_available ?? '-' }}</span></td></tr>
                    <tr>
                        <td class="info-label">Est. Price</td>
                        <td class="info-value" style="color: #000601;">: @if($product->price) Rp {{ number_format($product->price, 0, ',', '.') }} @else - @endif</td>
                    </tr>
                </table>

                <div class="spec-item-title">Dimension Details</div>
                <table class="dim-table-modern avoid-break">
                    <thead>
                        <tr><th>Item Code</th><th>Panjang (L)</th><th>Lebar (W)</th><th>Tinggi (H)</th><th>Kedalaman (D)</th></tr>
                    </thead>
                    <tbody>
                        @forelse($dimensions as $dim)
                        <tr>
                            <td style="font-weight: bold; color: #1a459c;">{{ $dim->item_code ?? '-' }}</td>
                            <td>{{ floatval($dim->panjang) }}</td>
                            <td>{{ floatval($dim->lebar) }}</td>
                            <td>{{ floatval($dim->tinggi) }}</td>
                            <td>{{ floatval($dim->kedalaman) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" style="padding: 15px; font-style: italic; color: #999;">- Data dimensi tidak tersedia -</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>



          <div class="page-break"></div>

            <div class="page-header">
                <h1 class="ph-title">{{ $product->nama_barang }}</h1>
                <h2 class="ph-subtitle">Component Parts</h2>
                <div class="ph-line"></div>
            </div>

            <div class="container-content">
                @if(count($items) > 0)
                    <table style="width: 100%; border-collapse: collapse; table-layout: fixed;">
                        @foreach($items->chunk(2) as $chunk)
                            @php $part = $chunk->values(); @endphp
                            <tr>
                                <td style="width: 50%; padding-right: 15px; vertical-align: top; padding-bottom: 30px;">
                                    @if(isset($part[0]))
                                        <div style="font-weight:bold; margin-bottom:8px; font-size:13px; color:#1a459c; line-height: 1.5;">
                                            {{ $part[0]->nama_item }}
                                        </div>
                                        
                                        <div style="width:100%; height:160px; background-color:#f8f9fa; text-align:center; margin-bottom: 15px; border-radius: 4px;">
                                            @if($part[0]->foto_item)
                                                <img src="{{ public_path('storage/' . $part[0]->foto_item) }}" style="max-width:90%; max-height:140px; object-fit:contain; margin-top: 10px;">
                                            @else
                                                <div style="padding-top:70px; color:#ccc;">No Image</div>
                                            @endif
                                        </div>
                                        
                                        <table style="width:100%; font-size:11px; border-collapse:collapse;">
                                            <tr>
                                                <td width="30%" style="color:#666; padding:6px 0; border-bottom:1px solid #f0f0f0;">Type</td>
                                                <td style="border-bottom:1px solid #f0f0f0;"><strong>: {{ $part[0]->tipe ?? '-' }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td style="color:#666; padding:6px 0; border-bottom:1px solid #f0f0f0;">Dimension</td>
                                                <td style="border-bottom:1px solid #f0f0f0;"><strong>: {{ $part[0]->dimensi_part ?? '-' }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td style="color:#666; padding:6px 0; border-bottom:1px solid #f0f0f0;">Config</td>
                                                <td style="border-bottom:1px solid #f0f0f0;"><strong>: {{ $part[0]->konfigurasi ?? '-' }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td style="color:#666; padding:6px 0; border-bottom:1px solid #f0f0f0;">Load</td>
                                                <td style="border-bottom:1px solid #f0f0f0;"><strong>: {{ $part[0]->load_capacity ?? '-' }}</strong></td>
                                            </tr>
                                        </table>
                                    @endif
                                </td>

                                <td style="width: 50%; padding-left: 15px; vertical-align: top; padding-bottom: 30px;">
                                    @if(isset($part[1]))
                                        <div style="font-weight:bold; margin-bottom:8px; font-size:13px; color:#1a459c; line-height: 1.5;">
                                            {{ $part[1]->nama_item }}
                                        </div>
                                        
                                        <div style="width:100%; height:160px; background-color:#f8f9fa; text-align:center; margin-bottom: 15px; border-radius: 4px;">
                                            @if($part[1]->foto_item)
                                                <img src="{{ public_path('storage/' . $part[1]->foto_item) }}" style="max-width:90%; max-height:140px; object-fit:contain; margin-top: 10px;">
                                            @else
                                                <div style="padding-top:70px; color:#ccc;">No Image</div>
                                            @endif
                                        </div>
                                        
                                        <table style="width:100%; font-size:11px; border-collapse:collapse;">
                                            <tr>
                                                <td width="30%" style="color:#666; padding:6px 0; border-bottom:1px solid #f0f0f0;">Type</td>
                                                <td style="border-bottom:1px solid #f0f0f0;"><strong>: {{ $part[1]->tipe ?? '-' }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td style="color:#666; padding:6px 0; border-bottom:1px solid #f0f0f0;">Dimension</td>
                                                <td style="border-bottom:1px solid #f0f0f0;"><strong>: {{ $part[1]->dimensi_part ?? '-' }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td style="color:#666; padding:6px 0; border-bottom:1px solid #f0f0f0;">Config</td>
                                                <td style="border-bottom:1px solid #f0f0f0;"><strong>: {{ $part[1]->konfigurasi ?? '-' }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td style="color:#666; padding:6px 0; border-bottom:1px solid #f0f0f0;">Load</td>
                                                <td style="border-bottom:1px solid #f0f0f0;"><strong>: {{ $part[1]->load_capacity ?? '-' }}</strong></td>
                                            </tr>
                                        </table>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <div style="text-align:center; color:#999; padding: 40px 0; font-style: italic;">- No component parts available -</div>
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


        </div> @if(!$loop->last)
            <div class="page-break"></div>
        @endif

    @endforeach


</body>
</html>