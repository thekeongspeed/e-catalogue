<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->nama_barang }}</title>
    <style>
        /* --- COPY CSS DARI PRINT CATALOG AGAR SAMA PERSIS --- */
        @page { margin: 0px; }
        body { margin: 0px; font-family: 'Helvetica', 'Arial', sans-serif; color: #000; }
        
        .page-break { page-break-after: always; }
        .clear { clear: both; }

        /* WARNA UTAMA */
        :root { --main-blue: #1a459c; }

        /* --- GLOBAL HEADER STYLE --- */
        .page-header {
            margin-top: 40px;
            margin-left: 40px;
            margin-right: 40px;
            margin-bottom: 20px;
        }
        .ph-title {
            font-size: 32px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            line-height: 1;
        }
        .ph-subtitle {
            font-size: 20px;
            font-weight: normal;
            margin: 5px 0 0 0;
            text-transform: uppercase;
        }
        .ph-line {
            width: 100px;
            height: 6px;
            background-color: #1a459c;
            margin-top: 15px;
        }

        /* --- HALAMAN 1: COVER --- */
        .cover-page { position: relative; width: 100%; height: 100%; }
        
        .cover-sidebar {
            position: absolute;
            top: 0; bottom: 0; left: 0;
            width: 20%;
            background-color: #1a459c;
            z-index: 1;
        }

        .cover-content {
            margin-left: 25%;
            padding-top: 60px;
            padding-right: 40px;
        }

        .cover-title {
            font-size: 60px;
            font-weight: 800;
            color: #0d2c6b;
            line-height: 0.9;
            text-transform: uppercase;
            margin-bottom: 50px;
        }

         .cover-title-customer {
            font-size: 60px;
            font-weight: 800;
            color: #4e4e4e;
            line-height: 0.9;
            text-transform: uppercase;
            margin-bottom: 50px;
        }


        .cover-image {
            width: 100%;
            height: 500px;
            object-fit: contain;
            margin-bottom: 50px;
            text-align: center;
        }
        .cover-image img { max-height: 100%; max-width: 100%; }

        .cover-footer {
            text-align: right;
            margin-top: 100px;
        }
        .cover-slogan {
            font-size: 24px;
            font-weight: bold;
            color: #000;
        }

        /* --- HALAMAN 2: SPESIFIKASI --- */
        .spec-container { padding: 0 40px; }
        
        .info-layout-table { width: 100%; margin-top: 30px; margin-bottom: 30px; border: none; }
        .info-layout-table td { vertical-align: top; }
        
        .spec-label { font-weight: bold; width: 140px; display: inline-block; padding-bottom: 10px; }
        .spec-value { display: inline-block; }

        .color-list { list-style: none; padding: 0; margin: 0; }
        .color-list li { margin-bottom: 5px; position: relative; padding-left: 15px; }
        .color-list li::before { content: "•"; position: absolute; left: 0; color: black; font-weight: bold; }

        /* Tabel Dimensi */
        .dim-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .dim-table th { 
            background-color: #eee; 
            padding: 12px; 
            text-align: center; 
            font-weight: normal; 
            border-bottom: 1px solid #ddd;
        }
        .dim-table td { 
            padding: 15px; 
            text-align: center; 
            border-bottom: 1px solid #ddd;
        }

        /* --- HALAMAN 3: PARTS --- */
        .parts-grid { margin: 0 40px; }
        .part-item {
            width: 46%;
            display: inline-block;
            vertical-align: top;
            margin-bottom: 40px;
            margin-right: 2%;
        }
        .part-title { font-weight: bold; font-size: 14px; margin-bottom: 10px; }
        .part-img-box {
            width: 100%; height: 150px; 
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 15px;
        }
        .part-img-box img { max-height: 100%; max-width: 100%; }
        
        .part-detail-table { width: 100%; font-size: 11px; }
        .part-detail-table td { padding: 4px 0; vertical-align: top; }
        .pd-label { width: 40%; color: #333; }
        .pd-val { width: 60%; }

        /* --- HALAMAN 4: PROJECT REFERENCES --- */
        .project-hero {
            width: 100%;
            height: 350px;
            overflow: hidden;
            margin-bottom: 20px;
            background: #f0f0f0;
        }
        .project-hero img { width: 100%; height: 100%; object-fit: cover; }
        
        .project-thumbnails { width: 100%; margin-top: 10px; }
        .proj-thumb {
            width: 32%;
            height: 150px;
            display: inline-block;
            margin-right: 1%;
            background: #f0f0f0;
            overflow: hidden;
            margin-bottom: 10px;
        }
        .proj-thumb img { width: 100%; height: 100%; object-fit: cover; }

        /* --- FOOTER --- */
        .footer-bar {
            position: fixed;
            bottom: 30px;
            right: 40px;
            text-align: right;
        }
        .footer-line {
            width: 150px;
            height: 6px;
            background-color: #1a459c;
            margin-bottom: 5px;
            display: inline-block;
        }
        .page-number { font-size: 12px; font-weight: bold; display: block; }
    </style>
</head>
<body>

    <div class="cover-page">
        <div class="cover-sidebar"></div>
        <div class="cover-content">
            <div class="cover-title-customer">
                {{ $product->nama_customer }}<br>
            </div>

            <div class="cover-title">
                 
                {{ strtoupper($product->nama_barang) }}<br>SPECIFICATION
                
            </div>


            <div class="cover-image">
                 @if($gallery->isNotEmpty())
                    <img src="{{ public_path('storage/' . $gallery->first()->image_path) }}">
                @else
                    <div style="padding-top:200px; color:#ccc;">No Cover Image</div>
                @endif
            </div>

            <div class="cover-footer">
                <div class="cover-slogan">
                   <br>
                    <span style="font-size: 16px; font-weight:normal;">Smart Solution for Better Life</span>
                </div>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="page-header">
        <h1 class="ph-title">{{ $product->nama_barang }}</h1>
        <h2 class="ph-subtitle">DISPLAY RACK FOR MINIMARKET</h2>
        <div class="ph-line"></div>
    </div>

    <div class="spec-container">
        <div style="text-align: center; height: 300px; margin-bottom: 20px;">
            @if($gallery->isNotEmpty())
                <img src="{{ public_path('storage/' . $gallery->first()->image_path) }}" style="height: 100%; max-width: 100%;">
            @endif
        </div>

        <table class="info-layout-table">
            <tr>
                <td width="60%">
                    <div><span class="spec-label">Base Material</span> <span class="spec-value">{{ $product->jenis_material ?? '-' }}</span></div>
                    <div style="margin-top: 15px;"><span class="spec-label">Finishing/Colour</span> <span class="spec-value">{{ $product->finishing ?? '-' }}</span></div>
                    <div style="margin-top: 15px;"><span class="spec-label">Type</span> <span class="spec-value">{{ $product->tipe ?? 'Single Sided / Double Sided' }}</span></div>
                </td>
                <td width="40%">
                    <div style="font-weight: bold; margin-bottom: 10px;">Colour Type</div>
                    <ul class="color-list">
                        <li>White Satin</li>
                        <li>Black Satin</li>
                        <li>Wood wood</li>
                    </ul>
                </td>
            </tr>
        </table>

       <table class="dim-table">
            <thead>
                <tr>
                    <th>Panjang (mm)</th>
                    <th>Lebar (mm)</th>
                    <th>Tinggi (mm)</th>
                    <th>Kedalaman (mm)</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($dimensions) && count($dimensions) > 0)
                    @foreach($dimensions as $dim)
                    <tr>
                        <td>{{ floatval($dim->panjang) }}</td>
                        <td>{{ floatval($dim->lebar) }}</td>
                        <td>{{ floatval($dim->tinggi) }}</td>
                        <td>{{ floatval($dim->kedalaman) }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" style="color: #999; font-style: italic;">- Data dimensi tidak tersedia -</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="footer-bar">
        <div class="footer-line"></div>
        <span class="page-number">1</span>
    </div>

    <div class="page-break"></div>

    <div class="page-header">
        <h1 class="ph-title">{{ $product->nama_barang }}</h1>
        <h2 class="ph-subtitle">PARTS</h2>
        <div class="ph-line"></div>
    </div>

    <div class="parts-grid">
        @if($items->isEmpty())
            <p style="text-align:center; color:#999;">No parts available.</p>
        @else
            @foreach($items as $item)
            <div class="part-item">
                <div class="part-title">{{ $item->nama_item }}</div>
                
                <div class="part-img-box">
                    @if($item->foto_item)
                        <img src="{{ public_path('storage/' . $item->foto_item) }}">
                    @else
                        <span style="color:#ccc;">No Image</span>
                    @endif
                </div>

                <table class="part-detail-table">
                    <tr>
                        <td class="pd-label">Type/Series</td>
                        <td class="pd-val">{{ $item->tipe ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="pd-label">Dimensions</td>
                        <td class="pd-val">{{ $item->dimensi_part ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="pd-label">Configuration</td>
                        <td class="pd-val">{{ $item->konfigurasi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="pd-label">Load Capacity</td>
                        <td class="pd-val">{{ $item->load_capacity ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            @endforeach
        @endif
    </div>

    <div class="footer-bar">
        <div class="footer-line"></div>
        <span class="page-number">2</span>
    </div>

    @if($projects->isNotEmpty())
        <div class="page-break"></div>

        <div class="page-header">
            <h1 class="ph-title">{{ $product->nama_barang }}</h1>
            <h2 class="ph-subtitle">PROJECT REFERENCES</h2>
            <div class="ph-line"></div>
        </div>

        <div class="spec-container">
            @php $firstProject = $projects->first(); @endphp
            <div class="project-hero">
                <img src="{{ public_path('storage/' . $firstProject->image_path) }}">
            </div>

            <div class="project-thumbnails">
                @foreach($projects->skip(1) as $proj)
                <div class="proj-thumb">
                    <img src="{{ public_path('storage/' . $proj->image_path) }}">
                </div>
                @endforeach
            </div>
        </div>

        <div class="footer-bar">
            <div class="footer-line"></div>
            <span class="page-number">3</span>
        </div>
    @endif

</body>
</html>