<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->nama_barang }} - Detail</title>
    
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
            position: relative;
            min-height: 100vh;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: url('/bg-watermark.png');
            background-position: center;
            background-repeat: no-repeat;
            background-size: 40%;
            opacity: 0.08;
            z-index: -1;
        }

        /* --- HEADER --- */
        .navbar-custom {
            background-color: #1a459c;
            padding: 20px 25px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            position: sticky; top: 0; z-index: 100;
        }
        .header-title { font-size: 20px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
        .btn-back { color: white; font-size: 24px; text-decoration: none; transition: 0.3s; }
        .btn-back:hover { transform: translateX(-5px); color: #ccc; }

        /* --- BUTTONS --- */
        .btn-group-action { display: flex; justify-content: center; gap: 15px; margin-bottom: 30px; flex-wrap: wrap; }
        .action-btn {
            background-color: #1f6f38; color: white; border-radius: 50px;
            padding: 10px 25px; font-weight: 500; font-size: 14px;
            text-decoration: none; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: 0.3s;
        }
        .action-btn:hover { background-color: #165c2b; color: white; transform: translateY(-2px); }

        /* --- IMAGE AREA --- */
        .image-container {
            position: relative; width: 100%; max-width: 700px; height: 450px;
            margin: 0 auto 40px auto; background: #fff; border-radius: 15px;
            overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08); border: 1px solid #eee;
        }
        .clickable-image { cursor: zoom-in; transition: transform 0.3s; }
        .zoom-icon {
            position: absolute; top: 15px; right: 15px;
            background: rgba(0,0,0,0.6); color: white; padding: 10px;
            border-radius: 50%; pointer-events: none;
        }
        .product-title { font-size: 32px; font-weight: 700; color: #222; margin-bottom: 25px; text-align: left; }

        /* --- TABS MENU --- */
        .tabs-container {
            display: flex; gap: 15px; margin-bottom: 30px;
            border-bottom: 2px solid #eee; padding-bottom: 15px; overflow-x: auto;
        }
        .tab-item {
            cursor: pointer; padding: 10px 25px; border-radius: 50px;
            font-weight: 500; color: #555; background: #fff; border: 1px solid #eee;
            white-space: nowrap; transition: 0.3s;
        }
        .tab-item.active {
            background-color: #1a459c; color: white; border-color: #1a459c;
            box-shadow: 0 4px 10px rgba(26, 69, 156, 0.3);
        }

        /* --- CONTENT AREA --- */
        .content-area {
            font-size: 15px; color: #444; min-height: 200px;
            background: white; padding: 30px; border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            animation: fadeIn 0.5s;
        }
        .hidden { display: none; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* --- SPECIFICATION TABLE STYLE --- */
        .spec-table {
            width: 100%; border-collapse: separate; border-spacing: 0;
            border-radius: 12px; overflow: hidden; border: 1px solid #eee; margin-bottom: 20px;
        }
        .spec-table td { padding: 12px 20px; border-bottom: 1px solid #eee; vertical-align: middle; }
        .spec-table tr:last-child td { border-bottom: none; }
        .spec-label { width: 35%; font-weight: 600; color: #555; background-color: #f8f9fa; border-right: 1px solid #eee; }
        .spec-value { font-weight: 500; color: #222; }
        .spec-header { background-color: #e9ecef; font-weight: 700; color: #1a459c; text-transform: uppercase; font-size: 13px; letter-spacing: 1px; }

        /* --- PARTS DETAIL STYLE --- */
        .part-card {
            display: flex; flex-direction: column; 
            background: #fff; border: 1px solid #eee; border-radius: 12px;
            overflow: hidden; margin-bottom: 20px; transition: 0.2s;
        }
        .part-card:hover { border-color: #1a459c; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        
        .part-img-wrapper {
            width: 100%; height: 200px; background: #f8f9fa;
            display: flex; align-items: center; justify-content: center;
            border-bottom: 1px solid #eee; cursor: zoom-in;
        }
        .part-img-wrapper img { max-width: 100%; max-height: 100%; object-fit: contain; }

        .part-details { padding: 20px; flex-grow: 1; }
        .part-title { font-size: 18px; font-weight: 700; color: #1a459c; margin-bottom: 15px; cursor: pointer; }
        .part-title:hover { text-decoration: underline; }

        .part-spec-table { width: 100%; font-size: 14px; }
        .part-spec-table td { padding: 5px 0; border-bottom: 1px dashed #eee; }
        .part-label { color: #666; width: 40%; }
        .part-val { font-weight: 600; color: #333; }

        @media (min-width: 768px) {
            .part-card { flex-direction: row; }
            .part-img-wrapper { width: 220px; height: auto; border-bottom: none; border-right: 1px solid #eee; }
        }

        /* --- LIGHTBOX FIX --- */
        .btn-close-lightbox {
            position: absolute; top: 15px; right: 15px;
            background: white; border-radius: 50%; opacity: 1; padding: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5); z-index: 1056;
        }
    </style>
</head>
<body>

    <div class="navbar-custom">
        <a href="/customer/{{ $product->nama_customer }}" class="btn-back"><i class="fas fa-arrow-left"></i></a>
        <div class="header-title">{{ $product->nama_customer }}</div>
        <div style="width: 24px;"></div>
    </div>

    <div class="container py-5">
        
        <div class="btn-group-action">
            <a href="/print?id={{ $product->id }}" target="_blank" class="action-btn">
                <i class="fas fa-file-pdf me-2"></i> Download PDF
            </a>
            </div>

        <div class="image-container">
            @if($gallery->isEmpty())
                <div class="d-flex justify-content-center align-items-center h-100">
                    <img src="https://via.placeholder.com/400x300?text=No+Image" style="max-height:80%;">
                </div>
            @else
                <div id="productCarousel" class="carousel slide h-100" data-bs-ride="carousel" data-bs-interval="3000">
                    <div class="carousel-indicators">
                        @foreach($gallery as $key => $img)
                            <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></button>
                        @endforeach
                    </div>
                    
                    <div class="carousel-inner h-100">
                        @foreach($gallery as $key => $img)
                        <div class="carousel-item h-100 {{ $key == 0 ? 'active' : '' }}">
                            <div class="d-flex justify-content-center align-items-center h-100 bg-white position-relative">
                                <img src="{{ asset('storage/' . $img->image_path) }}" 
                                     class="clickable-image" 
                                     style="max-height: 90%; max-width: 90%; object-fit: contain;" 
                                     onclick="openLightbox(this.src)">
                                <i class="fas fa-search-plus zoom-icon"></i>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    @if($gallery->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon bg-dark rounded-circle p-3"></span></button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next"><span class="carousel-control-next-icon bg-dark rounded-circle p-3"></span></button>
                    @endif
                </div>
            @endif
        </div>

        <h1 class="product-title">{{ $product->nama_barang }}</h1>

        <div class="tabs-container">
            <button class="tab-item active" onclick="openTab('spec', this)">Specification</button>
            <button class="tab-item" onclick="openTab('parts', this)">Component Parts</button>
            <button class="tab-item" onclick="openTab('project', this)">Project Reference</button>
        </div>

        <div class="content-wrapper">
            
           <div id="spec" class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h5 class="fw-bold text-primary m-0"><i class="fas fa-clipboard-list me-2"></i> Technical Specification</h5>
        
        @if(session('is_admin'))
            <div>
                <a href="{{ url('/edit-spec/' . $product->id) }}" class="btn btn-sm btn-warning rounded-pill px-3 me-2">
                    <i class="fas fa-edit me-1"></i> Edit Spec
                </a>
                <a href="{{ url('/delete-product/' . $product->id) }}" 
                   class="btn btn-sm btn-danger rounded-pill px-3"
                   onclick="return confirm('PERINGATAN: Apakah Anda yakin ingin menghapus produk {{ $product->nama_barang }}? \n\nData tidak bisa dikembalikan.')">
                    <i class="fas fa-trash-alt me-1"></i> Delete Product
                </a>
            </div>
        @endif
    </div>

    {{-- INFO CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div style="background:#f8f9fa; border-radius:12px; padding:15px; border:1px solid #eee;">
                <div style="font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Customer</div>
                <div style="font-size:15px; font-weight:700; color:#1a459c;">{{ $product->nama_customer }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div style="background:#f8f9fa; border-radius:12px; padding:15px; border:1px solid #eee;">
                <div style="font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Divisi</div>
                <div style="font-size:15px; font-weight:700; color:#333;">{{ $product->divisi ?? '-' }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div style="background:#f8f9fa; border-radius:12px; padding:15px; border:1px solid #eee;">
                <div style="font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Material</div>
                <div style="font-size:15px; font-weight:700; color:#333;">{{ $product->jenis_material ?? '-' }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div style="background:#f8f9fa; border-radius:12px; padding:15px; border:1px solid #eee;">
                <div style="font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Finishing</div>
                <div style="font-size:15px; font-weight:700; color:#333;">{{ $product->finishing ?? '-' }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div style="background:#f8f9fa; border-radius:12px; padding:15px; border:1px solid #eee;">
                <div style="font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Max Load</div>
                <div style="font-size:15px; font-weight:700; color:#333;">{{ !empty($product->max_load) ? $product->max_load . ' kg' : '-' }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div style="background:#f8f9fa; border-radius:12px; padding:15px; border:1px solid #eee;">
                <div style="font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Application</div>
                <div style="font-size:13px; font-weight:600; color:#333;">{{ $product->application ?? '-' }}</div>
            </div>
        </div>
    </div>

    {{-- DIMENSION TABLE --}}
    <div style="font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#1a459c; margin-bottom:12px;">
        <i class="fas fa-ruler-combined me-2"></i> Dimension Details
    </div>

    @if($dimensions->isEmpty())
        <div class="text-center text-muted fst-italic py-3">- Belum ada data dimensi -</div>
    @else
        <div style="border-radius:12px; overflow:hidden; border:1px solid #eee;">
            <table style="width:100%; border-collapse:collapse; font-size:14px;">
                <thead>
                    <tr style="background-color:#1a459c;">
                        <th style="padding:12px 20px; color:white; font-weight:600; text-align:left;">Item Code</th>
                        <th style="padding:12px 20px; color:white; font-weight:600; text-align:left;">Item Name</th>
                        <th style="padding:12px 20px; color:white; font-weight:600; text-align:left;">Dimension</th>
                        <th style="padding:12px 20px; color:white; font-weight:600; text-align:left;">Color</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dimensions as $i => $dim)
                    <tr style="background-color: {{ $i % 2 == 0 ? '#fff' : '#f8fafd' }};">
                        <td style="padding:12px 20px; border-bottom:1px solid #eee; font-weight:700; color:#1a459c;">{{ $dim->item_code ?? '-' }}</td>
                        <td style="padding:12px 20px; border-bottom:1px solid #eee;">{{ $dim->item_name ?? '-' }}</td>
                        <td style="padding:12px 20px; border-bottom:1px solid #eee;">{{ $dim->panjang ?? '-' }}</td>
                        <td style="padding:12px 20px; border-bottom:1px solid #eee;">{{ $dim->color ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <p class="small text-muted mt-3">* Spesifikasi dapat berubah disesuaikan dengan kebutuhan custom project.</p>
</div>


            <div id="parts" class="content-area hidden">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold text-primary m-0"><i class="fas fa-cubes me-2"></i> Component Details</h5>
                        @if(session('is_admin'))
                            <a href="{{ url('/edit-parts/' . $product->id) }}" class="btn btn-sm btn-warning rounded-pill px-3">
                                <i class="fas fa-edit me-1"></i> Edit Parts
                            </a>        
                        @endif
                    </div>
                    
                    @if($items->isEmpty())
                        <div class="text-muted fst-italic py-3 text-center">- Belum ada data komponen parts -</div>
                    @else
                        <div class="row g-3">
                            @foreach($items as $item)
                            <div class="col-12 col-md-6">
                                <div style="border:1px solid #e0e0e0; border-radius:14px; overflow:hidden; background:#fff; height:100%;">
                                    
                                    {{-- IMAGE + TITLE ROW --}}
                                    <div style="display:flex; align-items:stretch;">
                                        {{-- Gambar --}}
                                        <div onclick="openLightbox('{{ $item->foto_item ? asset('storage/'.$item->foto_item) : '' }}')"
                                            style="width:110px; min-height:110px; background:#f4f6fb; display:flex; align-items:center; justify-content:center; cursor:zoom-in; flex-shrink:0; border-right:1px solid #eee;">
                                            @if($item->foto_item)
                                                <img src="{{ asset('storage/'.$item->foto_item) }}" style="max-width:90px; max-height:90px; object-fit:contain;">
                                            @else
                                                <i class="fas fa-image fa-2x text-muted"></i>
                                            @endif
                                        </div>

                                        {{-- Nama & Deskripsi --}}
                                        <div style="padding:15px; flex-grow:1;">
                                            <div style="font-size:16px; font-weight:700; color:#1a459c; margin-bottom:6px;">
                                                {{ $item->nama_item ?? '-' }}
                                            </div>
                                            @if(!empty($item->deskripsi))
                                                <div style="font-size:12px; color:#666; line-height:1.6;">
                                                    {{ $item->deskripsi }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- SPEC GRID --}}
                                    <div style="background:#f8f9fa; border-top:1px solid #eee; display:grid; grid-template-columns:1fr 1fr; gap:0;">
                                        <div style="padding:10px 15px; border-right:1px solid #eee; border-bottom:1px solid #eee;">
                                            <div style="font-size:10px; color:#999; text-transform:uppercase; letter-spacing:0.5px;">Type / Series</div>
                                            <div style="font-size:13px; font-weight:600; color:#333; margin-top:2px;">{{ $item->tipe ?? '-' }}</div>
                                        </div>
                                        <div style="padding:10px 15px; border-bottom:1px solid #eee;">
                                            <div style="font-size:10px; color:#999; text-transform:uppercase; letter-spacing:0.5px;">Dimension</div>
                                            <div style="font-size:13px; font-weight:600; color:#333; margin-top:2px;">
                                                {{ !empty($item->dimensi_part) ? (stripos($item->dimensi_part, 'mm') === false ? $item->dimensi_part . ' mm' : $item->dimensi_part) : '-' }}
                                            </div>
                                        </div>
                                        <div style="padding:10px 15px; border-right:1px solid #eee;">
                                            <div style="font-size:10px; color:#999; text-transform:uppercase; letter-spacing:0.5px;">Configuration</div>
                                            <div style="font-size:13px; font-weight:600; color:#333; margin-top:2px;">{{ $item->konfigurasi ?? '-' }}</div>
                                        </div>
                                        <div style="padding:10px 15px;">
                                            <div style="font-size:10px; color:#999; text-transform:uppercase; letter-spacing:0.5px;">Load Capacity</div>
                                            <div style="font-size:13px; font-weight:600; color:#333; margin-top:2px;">
                                                {{ !empty($item->load_capacity) ? (stripos($item->load_capacity, 'kg') === false ? $item->load_capacity . ' kg' : $item->load_capacity) : '-' }}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            <div id="project" class="content-area hidden">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-primary m-0"><i class="fas fa-images me-2"></i> Project Implementation</h5>
                    @if(session('is_admin'))
                        <a href="{{ url('/edit-project/' . $product->id) }}" class="btn btn-sm btn-warning rounded-pill px-3">
                            <i class="fas fa-edit me-1"></i> Edit Project
                        </a>
                    @endif
                </div>
                
                @if($projects->isEmpty())
                    <div class="alert alert-light border text-center py-5">
                        <i class="fas fa-hard-hat fa-3x text-muted mb-3"></i>
                        <p class="mb-0 text-muted">Belum ada dokumentasi project reference untuk produk ini.</p>
                    </div>
                @else
                    <div class="row g-3">
                        @foreach($projects as $proj)
                        <div class="col-6 col-md-4">
                            <div class="ratio ratio-4x3 rounded overflow-hidden shadow-sm border mb-2" style="cursor: zoom-in;" onclick="openLightbox('{{ asset('storage/' . $proj->image_path) }}')">
                                <img src="{{ asset('storage/' . $proj->image_path) }}" class="img-fluid object-fit-cover">
                            </div>
                            <div class="text-center small fw-bold text-secondary">
                                <i class="fas fa-map-marker-alt me-1 text-danger"></i> 
                                {{ $proj->place ?? 'Lokasi Project' }}
                            </div>

                              @if(!empty($proj->description))
                                <div class="text-center small text-muted mt-1" style="font-size: 12px; line-height: 1.4;">
                                    {{ $proj->description }}
                                </div>
                                @endif
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
                
        </div>
    </div>

    <div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-transparent border-0 position-relative">
                <button type="button" class="btn-close btn-close-lightbox" data-bs-dismiss="modal" aria-label="Close"></button>
                
                <div class="modal-body text-center p-0">
                    <img id="lightboxImage" src="" class="img-fluid rounded shadow-lg" style="max-height: 90vh;">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Tab Logic
        function openTab(tabId, element) {
            // Hide all contents
            document.querySelectorAll('.content-area').forEach(el => el.classList.add('hidden'));
            // Remove active class from buttons
            document.querySelectorAll('.tab-item').forEach(el => el.classList.remove('active'));
            
            // Show selected content
            document.getElementById(tabId).classList.remove('hidden');
            // Add active class to clicked button
            element.classList.add('active');
        }

        // Lightbox Logic
        function openLightbox(imageSrc) {
            if(!imageSrc) return;
            document.getElementById('lightboxImage').src = imageSrc;
            new bootstrap.Modal(document.getElementById('lightboxModal')).show();
        }
    </script>
</body>
</html>