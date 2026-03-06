<!DOCTYPE html>
<html lang="id">


<head>
    <meta charset="UTF-8">
    <title>Katalog - {{ $name }}</title>

   @php
        $bgPath = public_path('background.png');
        $base64Bg = '';
        if(file_exists($bgPath)){
            $base64Bg = 'data:image/png;base64,' . base64_encode(file_get_contents($bgPath));
        }
    @endphp

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
        font-weight: 800; 
        src: url("{{ public_path('fonts/Poppins-Bold.ttf') }}") format('truetype');
    }

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

        /* --- 1. RESET & SETUP --- */
        @page { margin: 0px; }
        body { 
            margin: 0px; padding: 0px;
            font-family:  'Montserrat','Arial', sans-serif; 
            color: #333; 
            background: transparent;
            /* PERBAIKAN 1: counter-reset: page DIHAPUS DARI SINI */
        }
        
        .mc-title,.mc-title2, .mc-subtitle, 
        .prod-title, .toc-title, .toc-table th, 
        .ph-title, .spec-item-title, .dim-table-modern th,
        .part-title {
            font-family: 'Poppins', sans-serif ;
        }

        /* Page Break Aman */
        .page-break { page-break-after: always; height: 0; margin: 0; padding: 0;  border: none; display: block; clear: both; visibility: hidden; }
        .avoid-break { page-break-inside: avoid; } 

        /* --- 2. LAYOUT UTAMA (MAIN COVER) --- */
        .main-cover { 
            position: relative; 
            width: 100%; 
            height: 1050px;  
            background: transparent; 
        }
        .mc-sidebar { 
            position: absolute; 
            top: -60px;     
            bottom: -1500px;  
            left: -60px;    
            width: 30%; 
            background-color: #1a459c; 
            z-index: -1; 
        }
        .mc-content { position: absolute; top: 35%; left: 35%; right: 5%; z-index: 2; }
        .mc-title { font-size: 50px; font-weight: 800; color: #545555; line-height: 1.1; margin-bottom: 15px; text-transform: uppercase; }
        .mc-title2 { font-size: 50px; font-weight: 800; color: #1a459c; line-height: 1.1; margin-bottom: 15px; text-transform: uppercase; }
        .mc-subtitle { font-size: 22px; color: #666; letter-spacing: 2px; text-transform: uppercase; font-weight: normal; }
        .mc-footer { position: absolute; top: 15px; left: 35%; font-size: 14px; color: #999; }
        
        /* PERBAIKAN 2: right: 30 ditambah px menjadi right: 30px */
        .cover-slogan {margin-bottom: 10px; margin-right: 5px; border-top: 2px solid #eaeaea; padding-top: 15px; width: 80%;bottom: 50px; right: 40px;}

        /* --- 3. PEMBATAS BARANG (PRODUCT COVER) --- */
        .prod-cover { 
            position: relative; 
            width: 100%; 
            height: 1000px;  
            background: transparent; 
        }
        .prod-sidebar { 
            position: absolute; 
            top: -100px;    
            height: 1500px;   
            left: -60px;   
            width: 20%; 
            background-color: #1a459c; 
            z-index: -1;
        }
        .prod-content { position: absolute; top: 120px; left: 20%; right: 40px; }
        .prod-title { 
            font-size: 38px; font-weight: 800; color: #0d2c6b; text-transform: uppercase; 
            border-bottom: 4px solid #1a459c; padding-bottom: 15px; margin-bottom: 5px; display: inline-block; 
        }
        .prod-img-box { width: 100%; height: 450px; text-align: center; margin-bottom: 5px; display: block; background: #fafafa; border-radius: 8px;}
        .prod-img-box img { max-width: 95%; max-height: 95%; width: auto; height: auto; object-fit: contain; padding-top: 2.5%; }

        /* Badge untuk Kategori/Tipe */
        .badge { 
            display: inline-block; background: #f0f4fa; color: #1a459c; margin-top: 20px;
            padding: 8px 15px; border-radius: 4px; font-size: 14px; font-weight: bold; margin-right: 10px; border: 1px solid #d0deea;
        }

        /* --- 5. HEADER HALAMAN ISI --- */
        .page-header { margin: 40px 40px 20px 40px; }
        .ph-title { font-size: 26px; font-weight: bold; color: #1a459c; text-transform: uppercase; margin: 0; }
        .ph-subtitle { font-size: 15px; color: #666; text-transform: uppercase; margin-top: 5px; }
        .ph-line { width: 100%; height: 2px; background: #eaeaea; margin-top: 15px; }
        .container-content { padding: 0 40px; }

        /* --- 6. SPESIFIKASI --- */
        .spec-img-container { width: 100%; height: 400px; text-align: center; margin-bottom: 15px; border-radius: 6px; overflow: hidden; background: #ffffff; border: 1px solid #e0e0e0; }
        .spec-img-container img { max-height: 95%; max-width: 100%; width: auto; height: auto; object-fit: contain; }
        
        /* Tabel Info Utama */
        .info-table { width: 100%; font-size: 13px; margin-bottom: 30px; border-collapse: collapse; }
        .info-table td { padding: 8px 0; border-bottom: 1px dashed #eee; }
        .info-label { width: 140px; color: #000000; font-weight: bold; }
        .info-value { color: #000000; }

        .spec-item-title { font-size: 13px; text-transform: uppercase; color: #1a459c; font-weight: bold; letter-spacing: 1px; margin-bottom: 10px; }

        /* Tabel Dimensi Modern */
        .dim-table-modern { width: 100%; border-collapse: collapse; font-size: 12px; border: 1px solid #e0e0e0; margin-bottom: 30px; }
        .dim-table-modern th { background-color: #1a459c; color: white; padding: 10px 15px; text-align: center; font-weight: bold; text-transform: uppercase; }
        .dim-table-modern td { padding: 10px 15px; text-align: center; border-bottom: 1px solid #eee; color: #444; }
        .dim-table-modern tr:nth-child(even) { background-color: #f8fafd; }

        /* --- 7. PROJECT REFERENCE (BENTO GRID) --- */
        .project-page-fixed {
            page-break-before: always; 
            margin-left: 40px;
            margin-right: 40px;
            margin-top: 20px;
            margin-bottom: 20px; 
        }

        .project-header-clean {
            padding-bottom: 10px;
            margin-bottom: 5px;
        }

        .grid-table {
            width: 100%; 
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


        /* --- 8. STYLE UNTUK LOGO --- */
       .company-logo-link {
            position: absolute;
            top: 40px;
            right: 40px;
            z-index: 999; 
            display: block;
        }

        .company-logo {
            width: 150px; 
            height: auto;
            border: none;
        }

        .customer-logo {
            width: 280px; 
            max-width: 100%;
            height: auto;
            margin-bottom: 8px; 
            display: block;
        }

        /* --- 9. DAFTAR ISI --- */
        .toc-wrapper { width: 80%; margin: 60px auto; }
        .toc-title { text-align: center; font-size: 22px; font-weight: bold; color: #1a459c; text-transform: uppercase; margin-bottom: 30px; letter-spacing: 2px; }
        .toc-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .toc-table th { border-bottom: 2px solid #1a459c; font-weight: bold; color: #333; text-transform: uppercase; font-size: 12px; text-align: left; padding: 12px 5px; }
        .toc-table td { padding: 12px 5px; border-bottom: 1px dotted #ccc; }
        
      
        a.pagenum {
            text-decoration: none; 
            color: #1a459c; 
            font-weight: bold;
        }
        
        /* a.pagenum::after {
            content: target-counter(attr(href), page);
        } */

        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1; /* Cukup -1 agar di belakang teks tapi di depan kertas */
            opacity: 0.35;
            background-image: url("{{ $base64Bg }}");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover; /* Ini yang bikin gambar fit proporsional, sisa tepinya di-crop */
        }
        

    </style>
</head>
<body>


@if($base64Bg != '')
        <div class="background"></div>
    @endif


    <div class="main-cover">
        <div class="mc-sidebar"></div>
        <a href="https://www.spectrum-unitec.com" class="company-logo-link">
            <img src="{{ public_path('/logo-perusahaan.png') }}" class="company-logo" style="border: none;">
        </a>


        <div class="mc-footer">Generated on {{ date('d F Y') }}</div>

      <div class="mc-content" style="position: absolute; top: 250px; left: 35%; right: 40px; z-index: 2;">
            
            @if(isset($customer) && !empty($customer->logo_path))
                @php
                    $logoPath = public_path('storage/' . $customer->logo_path);
                @endphp
                @if(file_exists($logoPath))
                    <img src="{{ $logoPath }}" style="text-align: left; left: 40px; max-width: 250px; height: auto; margin-bottom: 20px; display: block;">
                @endif
            @endif
        
            <div style="text-align: left; left: 40px; font-size: 50px; font-weight: 800; color: #1a459c; line-height: 1.1; text-transform: uppercase; font-family: 'Poppins', sans-serif;">
                {{ strtoupper($name) }}
            </div> 
            
            <div style="text-align: left; left: 40px; font-size: 50px; font-weight: bold; color: #333; margin-top: 5px; font-family: 'Poppins', sans-serif;">
                CATALOGUE
            </div>
            
            <div style="text-align: left; left: 40px; font-size: 18px; font-weight: bold; color: #666; text-transform: uppercase; margin-top: 15px; font-family: 'Montserrat', sans-serif;">
                Official Product Document
            </div>
             
        </div>
           
    </div>

    <div style=" position: absolute; text-align: right;  bottom: 40px; right: 40px;  z-index: 999;">
            <span style="font-size: 16px; font-weight: normal; color: #333; font-family: 'Montserrat', sans-serif;">
                Smart Solutions for Better Life
            </span>
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
                    <td style="font-weight: bold; text-align: center; color: #070707;">{{ sprintf('%02d', $index + 1) }}.</td>
                    
                    <td style="font-weight: bold; font-family: 'Poppins', sans-serif;">
                        <a href="#product-{{ $item['product']->id }}" style="text-decoration: none; color: #2c2c2c;">
                            {{ $item['product']->nama_barang }}
                        </a>
                    </td>
                    
                   <td style="text-align: left; padding-left: 45px; font-weight: bold;">
                    <a href="#product-{{ $item['product']->id }}" class="pagenum" style="text-decoration: none; color: #1a459c; font-family: Helvetica, Arial, sans-serif;">
                        {P_{{ $item['product']->id }}}
                    </a>
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

        <script type="text/php">
        if (isset($pdf)) {
            $GLOBALS['toc_{{ $product->id }}'] = $pdf->get_page_number();
        }
    </script>


       <div id="product-{{ $product->id }}" style="color: #fff; font-size: 1px; line-height: 1px; margin: 0; padding: 0; position: static;">.</div>

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
                        <span class="badge">DIVISI: {{ strtoupper($product->divisi ?? '-') }}</span>
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
                    @if($gallery->count() > 1)
                    <img src="{{ public_path('storage/' . $gallery->skip(1)->first()->image_path) }}">
                @elseif($gallery->isNotEmpty())
                    <img src="{{ public_path('storage/' . $gallery->first()->image_path) }}">
                @else
                    <div style="padding-top:180px; color:#ccc; font-style:italic;">No Image Available</div>
                @endif
                </div>

                <table style="width: 100%; border-collapse: collapse; table-layout: fixed; margin-bottom: 20px;">
    <tr>
        {{-- KOLOM KIRI: GENERAL SPECIFICATION --}}
       
        <td style="width: 50%; vertical-align: top; padding-right: 10px; background: #ffffff; border: 1px solid #e0e0e0; border-radius: 6px; padding: 15px; box-shadow: 0 2px 6px rgba(0,0,0,0.05">
            <div class="spec-item-title">General Specification</div>
            <table class="info-table">
                <tr>
                    <td class="info-label">Material</td>
                    <td class="info-value">: {{ $product->jenis_material ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Finishing</td>
                    <td class="info-value">: {{ $product->finishing ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Max Load</td>
                    <td class="info-value">: {{ !empty($product->max_load) ? $product->max_load . ' kg' : '-' }}</td>
                </tr>
            </table>
        </td>
       
        {{-- KOLOM KANAN: APPLICATION --}}
        
        <td style="width: 50%; vertical-align: top; padding-left: 10px; background: #ffffff; border: 1px solid #e0e0e0; border-radius: 6px; padding: 15px; box-shadow: 0 2px 6px rgba(0,0,0,0.05">
            <div class="spec-item-title">Application</div>
            @if(!empty($product->application))
                @foreach(explode(',', $product->application) as $app)
                <div style="display: flex; align-items: center; padding: 5px 0; border-bottom: 1px dashed #eee; font-size: 13px;">
                    <span style="display: inline-block; width: 8px; height: 8px; background-color: #1a459c; border-radius: 50%; margin-right: 10px; margin-bottom: 1px;"></span>
                    <span style="color: #333;">{{ trim($app) }}</span>
                </div>
                @endforeach
            @else
                <div style="color: #ccc; font-style: italic; font-size: 13px;">- Tidak tersedia -</div>
            @endif
        </td>
    </tr>
</table>
           

                <div class="spec-item-title">Dimension Details</div>
                <table class="dim-table-modern avoid-break">
                    <thead>
                        <tr><th>Item Code</th><th>Item Name</th><th>Dimension</th><th>Color</th></tr>
                    </thead>
                    <tbody>
                        @forelse($dimensions as $dim)
                            <tr>
                                <td style="font-weight: bold; color: #1a459c;">{{ $dim->item_code ?? '-' }}</td>
                                <td>{{ $dim->item_name ?? '-' }}</td>
                                <td>{{ $dim->panjang ?? '-' }}</td>
                                <td>{{ $dim->color ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" style="padding: 15px; font-style: italic; color: #999;">- Data dimensi tidak tersedia -</td></tr>
                            @endforelse
                    </tbody>
                </table>
            </div>



@if(count($items) > 0)
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
                    <div style="font-size:10px; font-weight:bold; color:#fff; text-transform:uppercase; letter-spacing:1px;">Technical Specification</div>
                </div>
                <table style="width:100%; border-collapse:collapse; font-size:11px; font-family:'Montserrat',sans-serif;">
                    <tr><td style="color:#888; padding:6px 15px; width:45%; border-bottom:1px solid #f0f0f0;">Type</td><td style="color:#222; padding:6px 15px; font-weight:bold; border-bottom:1px solid #f0f0f0;">{{ $part[0]->tipe ?? '-' }}</td></tr>
                    <tr style="background:#fafafa;"><td style="color:#888; padding:6px 15px; border-bottom:1px solid #f0f0f0;">Dimension</td><td style="color:#222; padding:6px 15px; font-weight:bold; border-bottom:1px solid #f0f0f0;">{{ !empty($part[0]->dimensi_part) ? (stripos($part[0]->dimensi_part, 'mm') === false ? $part[0]->dimensi_part . ' mm' : $part[0]->dimensi_part) : '-' }}</td></tr>
                    <tr><td style="color:#888; padding:6px 15px; border-bottom:1px solid #f0f0f0;">Configuration</td><td style="color:#222; padding:6px 15px; font-weight:bold; border-bottom:1px solid #f0f0f0;">{{ $part[0]->konfigurasi ?? '-' }}</td></tr>
                    <tr style="background:#fafafa;"><td style="color:#888; padding:6px 15px;">Load Capacity</td><td style="color:#222; padding:6px 15px; font-weight:bold;">{{ !empty($part[0]->load_capacity) ? (stripos($part[0]->load_capacity, 'kg') === false ? $part[0]->load_capacity . ' kg' : $part[0]->load_capacity) : '-' }}</td></tr>
                </table>
            </div>
            @endif
        </td>

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
                    <div style="font-size:10px; font-weight:bold; color:#fff; text-transform:uppercase; letter-spacing:1px;">Technical Specification</div>
                </div>
                <table style="width:100%; border-collapse:collapse; font-size:11px; font-family:'Montserrat',sans-serif;">
                    <tr><td style="color:#888; padding:6px 15px; width:45%; border-bottom:1px solid #f0f0f0;">Type</td><td style="color:#222; padding:6px 15px; font-weight:bold; border-bottom:1px solid #f0f0f0;">{{ $part[1]->tipe ?? '-' }}</td></tr>
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
    @else
        <div style="text-align:center; color:#999; padding: 40px 0; font-style: italic;">- No component parts available -</div>
    @endif
</div>

@endif


                    @if(count($projects) > 0)
    @foreach($projects->chunk(5) as $chunk)
        @php $imgs = $chunk->values(); @endphp

        <div class="project-page-fixed">
            
            {{-- HEADER --}}
            <div class="project-header-clean">
                <h1 class="ph-title">{{ $product->nama_barang }}</h1>
                <h2 class="ph-subtitle" style="text-transform:uppercase; font-weight:bold; color:#333; font-size:13px; letter-spacing:1px;">
                    Project References & Installation Highlights
                </h2>
                <div class="ph-line"></div>
            </div>

            {{-- HERO IMAGE --}}
            @if(isset($imgs[0]))
            <div style="margin-bottom:6px;">
                {{-- Foto hero --}}
                <div style="width:100%; height:320px; border-radius:6px; overflow:hidden;">
                    <img src="{{ public_path('storage/' . $imgs[0]->image_path) }}" 
                         style="width:100%; height:100%; object-fit:cover; display:block;">
                </div>
                {{-- Label lokasi --}}
                <div style="background:#1a459c; border-radius:0 0 6px 6px; padding:8px 14px;">
                    <div style="font-size:12px; font-weight:bold; color:#fff; font-family:'Poppins',sans-serif; text-transform:uppercase;">
                        {{ $imgs[0]->place ?? '' }}
                    </div>
                </div>
                {{-- Deskripsi di luar foto --}}
                @if(!empty($imgs[0]->description))
                <div style="padding:8px 4px; font-size:10px; color:#555; line-height:1.6;">
                    {{ Str::words($imgs[0]->description, 10) }}
                </div>
                @endif
            </div>
            @endif

            {{-- ROW 1: gambar ke 2 & 3 --}}
            @if(isset($imgs[1]) || isset($imgs[2]))
            <table style="width:100%; border-collapse:separate; border-spacing:8px 0; margin-bottom:6px;">
                <tr>
                    <td style="width:50%; padding-right:4px; vertical-align:top;">
                        @if(isset($imgs[1]))
                        <div>
                            <div style="height:180px; border-radius:6px; overflow:hidden;">
                                <img src="{{ public_path('storage/' . $imgs[1]->image_path) }}" 
                                     style="width:100%; height:100%; object-fit:cover; display:block;">
                            </div>
                            <div style="background:#1a459c; border-radius:0 0 6px 6px; padding:6px 12px;">
                                <div style="font-size:10px; font-weight:bold; color:#fff; font-family:'Poppins',sans-serif; text-transform:uppercase;">
                                    {{ $imgs[1]->place ?? '' }}
                                </div>
                            </div>
                            @if(!empty($imgs[1]->description))
                            <div style="padding:5px 2px; font-size:9px; color:#555; line-height:1.5;">
                               {{ Str::words($imgs[1]->description, 10) }}
                            </div>
                            @endif
                        </div>
                        @endif
                    </td>
                    <td style="width:50%; padding-left:4px; vertical-align:top;">
                        @if(isset($imgs[2]))
                        <div>
                            <div style="height:180px; border-radius:6px; overflow:hidden;">
                                <img src="{{ public_path('storage/' . $imgs[2]->image_path) }}" 
                                     style="width:100%; height:100%; object-fit:cover; display:block;">
                            </div>
                            <div style="background:#1a459c; border-radius:0 0 6px 6px; padding:6px 12px;">
                                <div style="font-size:10px; font-weight:bold; color:#fff; font-family:'Poppins',sans-serif; text-transform:uppercase;">
                                    {{ $imgs[2]->place ?? '' }}
                                </div>
                            </div>
                            @if(!empty($imgs[2]->description))
                            <div style="padding:5px 2px; font-size:9px; color:#555; line-height:1.5;">
                                {{ Str::words($imgs[2]->description, 10) }}
                            </div>
                            @endif
                        </div>
                        @endif
                    </td>
                </tr>
            </table>
            @endif

            {{-- ROW 2: gambar ke 4 & 5 --}}
            @if(isset($imgs[3]) || isset($imgs[4]))
            <table style="width:100%; border-collapse:separate; border-spacing:8px 0; margin-top:15px;">
                <tr>
                    <td style="width:50%; padding-right:4px; vertical-align:top;">
                        @if(isset($imgs[3]))
                        <div>
                            <div style="height:180px; border-radius:6px; overflow:hidden;">
                                <img src="{{ public_path('storage/' . $imgs[3]->image_path) }}" 
                                     style="width:100%; height:100%; object-fit:cover; display:block;">
                            </div>
                            <div style="background:#1a459c; border-radius:0 0 6px 6px; padding:6px 12px;">
                                <div style="font-size:10px; font-weight:bold; color:#fff; font-family:'Poppins',sans-serif; text-transform:uppercase;">
                                    {{ $imgs[3]->place ?? '' }}
                                </div>
                            </div>
                            @if(!empty($imgs[3]->description))
                            <div style="padding:5px 2px; font-size:9px; color:#555; line-height:1.5;">
                                {{ Str::words($imgs[3]->description, 10) }}
                            </div>
                            @endif
                        </div>
                        @endif
                    </td>
                    <td style="width:50%; padding-left:4px; vertical-align:top;">
                        @if(isset($imgs[4]))
                        <div>
                            <div style="height:180px; border-radius:6px; overflow:hidden;">
                                <img src="{{ public_path('storage/' . $imgs[4]->image_path) }}" 
                                     style="width:100%; height:100%; object-fit:cover; display:block;">
                            </div>
                            <div style="background:#1a459c; border-radius:0 0 6px 6px; padding:6px 12px;">
                                <div style="font-size:10px; font-weight:bold; color:#fff; font-family:'Poppins',sans-serif; text-transform:uppercase;">
                                    {{ $imgs[4]->place ?? '' }}
                                </div>
                            </div>
                            @if(!empty($imgs[4]->description))
                            <div style="padding:5px 2px; font-size:9px; color:#555; line-height:1.5;">
                                {{ Str::words($imgs[4]->description, 10) }}
                            </div>
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

        </div> 
        
        @if(!$loop->last)
            <div class="page-break"></div>
        @endif

    @endforeach

<script type="text/php">
        if (isset($pdf)) {
            // 1. SCRIPT MENCETAK NOMOR HALAMAN
            $pdf->page_script('
                // Kurangi 2 agar fisik halaman ke-3 (Product) menjadi Angka 1
                $displayNum = $PAGE_NUM - 2; 
                
                // Cetak nomor HANYA jika displayNum lebih dari 0 
                // (Cover dan Daftar Isi akan dilewati/tidak dicetak angkanya)
                if ($displayNum > 0) {
                    $font = $fontMetrics->get_font("Poppins", "normal"); 
                    $y = $pdf->get_height() - 35; 
                    $x = $pdf->get_width() - 40;  
                    
                    // Garis biru dan Angka
                    $pdf->line($x - 20, $y - 10, $x + 10, $y - 10, array(26/255, 69/255, 156/255), 2.5);
                    $pdf->text($x, $y, $displayNum, $font, 9, array(0.2, 0.2, 0.2));
                }
            ');

            // 2. SCRIPT PENGGANTI ANGKA DAFTAR ISI AGAR SINKRON
            $cpdf = $pdf->get_cpdf();
            foreach ($cpdf->objects as &$obj) {
                if (isset($obj["c"])) {
                    foreach ($GLOBALS as $key => $pageNum) {
                        if (strpos($key, "toc_") === 0) {
                            $id = str_replace("toc_", "", $key);
                            
                            // Daftar isi juga WAJIB dikurangi 2 agar sinkron dengan footer
                            $displayTocNum = $pageNum - 2;
                            $obj["c"] = str_replace("{P_" . $id . "}", $displayTocNum, $obj["c"]);
                        }
                    }
                }
            }
        }
    </script>
</body>
</html>