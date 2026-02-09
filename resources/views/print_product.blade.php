<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->nama_barang }}</title>
    <style>
        /* GAYA CSS SAMA SEPERTI KATALOG */
        body { font-family: sans-serif; color: #333; }
        .header { border-bottom: 2px solid #1a459c; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { color: #1a459c; margin: 0; font-size: 24px; text-transform: uppercase; }
        .header span { font-size: 14px; color: #666; }
        
        .main-image { width: 100%; height: 350px; object-fit: contain; margin-bottom: 20px; border: 1px solid #eee; background: #f9f9f9; text-align: center; }
        .main-image img { max-height: 100%; max-width: 100%; }

        .spec-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 13px; }
        .spec-table th, .spec-table td { border: 1px solid #ddd; padding: 8px; }
        .spec-table th { background-color: #f0f4f8; text-align: left; color: #1a459c; width: 35%; }
        
        .section-title { background-color: #1a459c; color: white; padding: 8px 15px; font-size: 15px; font-weight: bold; margin-bottom: 15px; border-radius: 4px; }

        .part-container { width: 100%; border-bottom: 1px solid #eee; padding: 15px 0; }
        .part-table { width: 100%; }
        .part-img-cell { width: 100px; vertical-align: top; }
        .part-img { width: 80px; height: 80px; object-fit: cover; border: 1px solid #ddd; }
        .part-info-cell { vertical-align: top; padding-left: 15px; }
        .part-name { font-size: 14px; font-weight: bold; margin-bottom: 5px; display: block; }
        .part-detail { font-size: 12px; color: #555; }
        
        .project-grid { width: 100%; margin-top: 10px; }
        .project-cell { width: 48%; display: inline-block; vertical-align: top; margin-bottom: 15px; margin-right: 2%; }
        .project-img { width: 100%; height: 180px; object-fit: cover; border: 1px solid #ddd; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

    <div class="header">
        <h1>{{ $product->nama_barang }}</h1>
        <span>Category: {{ $product->nama_customer }}</span>
    </div>

    <div class="main-image">
        @if($gallery->isNotEmpty())
            <img src="{{ public_path('storage/' . $gallery->first()->image_path) }}">
        @else
            <div style="padding-top:150px; color:#ccc;">No Image</div>
        @endif
    </div>

    <div class="section-title">Technical Specification</div>
    <table class="spec-table">
        <tr><th>Product Name</th><td>{{ $product->nama_barang }}</td></tr>
        <tr><th>Material</th><td>{{ $product->jenis_material ?? '-' }}</td></tr>
        <tr><th>Finishing</th><td>{{ $product->finishing ?? '-' }}</td></tr>
        <tr><th colspan="2" style="background-color: #e9ecef; text-align:center;">DIMENSION (mm)</th></tr>
        <tr><th>Panjang</th><td>{{ $product->panjang }} mm</td></tr>
        <tr><th>Lebar</th><td>{{ $product->lebar }} mm</td></tr>
        <tr><th>Tinggi</th><td>{{ $product->tinggi }} mm</td></tr>
    </table>

    <div class="page-break"></div>

    <div class="section-title">Component Details</div>
    @if($items->isEmpty())
        <p style="text-align: center; color: #999;">- No components data -</p>
    @else
        @foreach($items as $item)
        <div class="part-container">
            <table class="part-table">
                <tr>
                    <td class="part-img-cell">
                        @if($item->foto_item)
                            <img src="{{ public_path('storage/' . $item->foto_item) }}" class="part-img">
                        @endif
                    </td>
                    <td class="part-info-cell">
                        <span class="part-name">{{ $item->nama_item }}</span>
                        <div class="part-detail">
                            Type: {{ $item->tipe ?? '-' }} | Dim: {{ $item->dimensi_part ?? '-' }} <br>
                            Config: {{ $item->konfigurasi ?? '-' }} | Load: {{ $item->load_capacity ?? '-' }}
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        @endforeach
    @endif

    <div class="page-break"></div>

    <div class="section-title">Project Reference</div>
    @if($projects->isEmpty())
        <p style="text-align: center; color: #999;">- No project data -</p>
    @else
        <div class="project-grid">
            @foreach($projects as $p)
            <div class="project-cell">
                <img src="{{ public_path('storage/' . $p->image_path) }}" class="project-img">
                <div style="text-align: center; font-size: 11px; font-weight: bold; margin-top: 5px;">
                    📍 {{ $p->place ?? 'Location' }}
                </div>
            </div>
            @endforeach
        </div>
    @endif

</body>
</html>