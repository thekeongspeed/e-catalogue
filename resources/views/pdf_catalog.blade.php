<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body { font-family: sans-serif; color: #333; }
        .page-break { page-break-after: always; }
        
        /* Header Halaman */
        header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        h1 { margin: 0; font-size: 24px; text-transform: uppercase; }
        
        /* Layout Kartu Produk */
        .product-container {
            border: 1px solid #ddd;
            margin-bottom: 20px;
            padding: 10px;
            page-break-inside: avoid; /* Mencegah produk terpotong antar halaman */
        }
        
        table { width: 100%; border-collapse: collapse; }
        td { vertical-align: top; }

        /* Kolom Gambar */
        .col-image { width: 40%; text-align: center; padding-right: 15px; background: #fafafa; border: 1px solid #eee; }
        .col-image img { max-width: 100%; max-height: 200px; object-fit: contain; }

        /* Kolom Info */
        .col-info { width: 60%; }
        .customer-badge { background: #000; color: #fff; padding: 4px 8px; font-size: 10px; font-weight: bold; text-transform: uppercase; display: inline-block; margin-bottom: 5px;}
        .product-name { font-size: 18px; font-weight: bold; margin-bottom: 5px; color: #000; }
        .item-code { font-size: 14px; color: #555; margin-bottom: 15px; font-style: italic; }

        /* Tabel Spesifikasi Kecil */
        .specs { width: 100%; font-size: 12px; }
        .specs td { padding: 3px 0; border-bottom: 1px dotted #ccc; }
        .specs .label { font-weight: bold; width: 30%; }
    </style>
</head>
<body>
    <header>
        <h1>Product Catalog Library</h1>
        <p>Generated on: {{ date('d F Y') }}</p>
    </header>

    @foreach($items as $item)
    <div class="product-container">
        <table>
            <tr>
                <td class="col-image">
                    @if($item->foto_barang)
                        <img src="{{ public_path('storage/' . $item->foto_barang) }}">
                    @else
                        <div style="padding:40px; color:#aaa;">No Image</div>
                    @endif
                </td>
                <td class="col-info">
                    <span class="customer-badge">{{ $item->nama_customer }}</span>
                    <div class="product-name">{{ $item->nama_barang }}</div>
                    <div class="item-code">Item Code: {{ $item->nama_item }}</div>

                    <table class="specs">
                        <tr><td class="label">Dimensi (PxLxT)</td><td>{{ $item->panjang }} x {{ $item->lebar }} x {{ $item->tinggi }} cm</td></tr>
                        <tr><td class="label">Kedalaman</td><td>{{ $item->kedalaman ?? '-' }} cm</td></tr>
                        <tr><td class="label">Material</td><td>{{ $item->jenis_material }}</td></tr>
                        <tr><td class="label">Finishing</td><td>{{ $item->finishing }}</td></tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    @endforeach
</body>
</html>