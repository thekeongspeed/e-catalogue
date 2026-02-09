<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Katalog Baru</title>
    <title>E-Catalogue UT</title>
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
            min-height: 100vh;
            padding-bottom: 80px;
            position: relative;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: url('/bg-watermark.png');
            background-position: center;
            background-repeat: no-repeat;
            background-size: 40%;
            opacity: 0.08; /* Ubah ini untuk mengatur ketipisan */
            z-index: -1;
        }

        .navbar-custom {
            background-color: #1a459c; padding: 15px 25px;
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin-bottom: 30px;
        }
        .btn-home { color: white; font-size: 24px; text-decoration: none; }
        .btn-logout {
            background-color: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3);
            padding: 8px 25px; border-radius: 50px; font-weight: 500; text-decoration: none; font-size: 14px;
        }

        .page-title { font-size: 22px; font-weight: 600; margin-bottom: 20px; color: #333; }
        
        .section-card {
            background: white; border-radius: 15px; padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.03); margin-bottom: 25px; border: 1px solid #f0f0f0;
        }
        .section-label { font-size: 16px; font-weight: 600; color: #1a459c; margin-bottom: 15px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; }
        
        .form-control {
            border-radius: 10px; border: 1px solid #ddd; padding: 10px 15px; font-size: 14px;
        }
        .form-control:focus { border-color: #1a459c; box-shadow: 0 0 0 3px rgba(26, 69, 156, 0.1); }

        /* ITEM PART CARD STYLE */
        .item-part-card {
            background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 12px;
            padding: 20px; margin-bottom: 15px; position: relative;
        }
        .btn-remove-part {
            position: absolute; top: -10px; right: -10px;
            width: 30px; height: 30px; border-radius: 50%;
            background: #dc3545; color: white; border: none;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .btn-action-group { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }
        .btn-custom { border: none; border-radius: 50px; padding: 12px 40px; font-weight: 600; font-size: 15px; min-width: 140px; }
        .btn-batal { background-color: #dc1f26; color: white; text-decoration: none; text-align: center; display: inline-flex; align-items: center; justify-content: center; }
        .btn-tambah { background-color: #008a3c; color: white; }
    </style>
</head>
<body>

    <div class="navbar-custom">
        <a href="/" class="btn-home"><i class="fas fa-home"></i></a>
        <a href="/logout" class="btn-logout">Logout</a>
    </div>

    <div class="container" style="max-width: 900px;">
        <div class="page-title">Tambah Katalog Baru</div>

        @if(session('success')) <div class="alert alert-success rounded-3 shadow-sm border-0">{{ session('success') }}</div> @endif
        @if ($errors->any()) <div class="alert alert-danger rounded-3 shadow-sm border-0"><ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul></div> @endif

        <form action="/store" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="section-card">
                <div class="section-label"><i class="fas fa-info-circle me-2"></i> Informasi Dasar</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="small fw-bold text-muted">Nama Customer</label>
                        <input type="text" name="nama_customer" class="form-control" placeholder="Contoh: Indomaret" required>
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold text-muted">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Rak Gondola T30" required>
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold text-muted">Material Utama</label>
                        <input type="text" name="jenis_material" class="form-control" placeholder="Contoh: Steel SS400">
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold text-muted">Finishing / Warna</label>
                        <input type="text" name="finishing" class="form-control" placeholder="Contoh: Powder Coating White">
                    </div>
                </div>
            </div>

            <div class="section-card">
                <div class="section-label"><i class="fas fa-ruler-combined me-2"></i> Dimensi Produk Utama (mm)</div>
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <label class="small text-muted">Panjang (mm)</label>
                        <input type="number" step="0.1" name="panjang" class="form-control">
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="small text-muted">Lebar (mm)</label>
                        <input type="number" step="0.1" name="lebar" class="form-control">
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="small text-muted">Tinggi (mm)</label>
                        <input type="number" step="0.1" name="tinggi" class="form-control">
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="small text-muted">Kedalaman (mm)</label>
                        <input type="number" step="0.1" name="kedalaman" class="form-control">
                    </div>
                </div>
            </div>

            <div class="section-card">
                <div class="section-label"><i class="fas fa-images me-2"></i> Foto Gallery (Slideshow)</div>
                <p class="small text-muted mb-3">Upload foto utama produk. Bisa lebih dari satu.</p>
                
                <div id="gallery-container">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <input type="file" name="foto_barang[]" class="form-control" accept="image/*" onchange="previewImage(this)">
                        <div style="width:50px; height:50px; background:#eee; border-radius:8px; overflow:hidden; display:none;">
                            <img src="" style="width:100%; height:100%; object-fit:cover;">
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill mt-2" onclick="addGalleryInput()">
                    <i class="fas fa-plus me-1"></i> Tambah Foto Lain
                </button>
            </div>

            <div class="section-card">
                <div class="section-label"><i class="fas fa-cubes me-2"></i> Komponen Parts</div>
                <p class="small text-muted mb-3">Masukkan detail per komponen.</p>
                
                <div id="items-container">
                    <div class="item-part-card">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="small fw-bold text-primary">Nama Part / Item *</label>
                                <input type="text" name="items[0][name]" class="form-control" placeholder="Contoh: Shelving Base" required>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-primary">Foto Part</label>
                                <div class="d-flex gap-2">
                                    <input type="file" name="items[0][image]" class="form-control" onchange="previewImage(this)">
                                    <div style="width:40px; height:40px; background:#eee; border-radius:5px; overflow:hidden; display:none;">
                                        <img src="" style="width:100%; height:100%; object-fit:cover;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3"><label class="small text-muted">Tipe / Series</label><input type="text" name="items[0][tipe]" class="form-control"></div>
                            <div class="col-6 col-md-3"><label class="small text-muted">Dimensi (mm)</label><input type="text" name="items[0][dimensi]" class="form-control"></div>
                            <div class="col-6 col-md-3"><label class="small text-muted">Konfigurasi</label><input type="text" name="items[0][konfigurasi]" class="form-control"></div>
                            <div class="col-6 col-md-3"><label class="small text-muted">Load Capacity</label><input type="text" name="items[0][load]" class="form-control"></div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill w-100" onclick="addPartInput()">
                    <i class="fas fa-plus-circle me-1"></i> Tambah Komponen Lain
                </button>
            </div>

            <div class="section-card">
                <div class="section-label"><i class="fas fa-hard-hat me-2"></i> Project Reference</div>
                <p class="small text-muted mb-3">Upload dokumentasi foto hasil pengerjaan proyek (Opsional).</p>
                
               <div id="project-container">
                    <div class="row g-2 mb-2 align-items-center position-relative">
                        <div class="col-5">
                            <input type="text" name="project_places[]" class="form-control" placeholder="Nama Tempat / Lokasi">
                        </div>
                        <div class="col-6">
                            <input type="file" name="project_images[]" class="form-control" accept="image/*" onchange="previewImage(this)">
                        </div>
                        <div class="col-1">
                            <button type="button" class="btn btn-secondary btn-sm rounded-circle" style="width:30px; height:30px; padding:0;" disabled><i class="fas fa-times"></i></button>
                        </div>
                        <div class="col-12 mt-1" style="display:none;">
                            <div style="width:60px; height:60px; background:#eee; border-radius:8px; overflow:hidden;">
                                <img src="" style="width:100%; height:100%; object-fit:cover;">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill mt-2" onclick="addProjectInput()">
                    <i class="fas fa-plus me-1"></i> Tambah Foto Project Lain
                </button>
            </div>

            <div class="btn-action-group">
                <a href="/" class="btn-custom btn-batal">Batal</a>
                <button type="submit" class="btn-custom btn-tambah">Simpan Katalog</button>
            </div>
        </form>
    </div>

    <script>
        let itemIndex = 1;

        // 1. Fungsi Tambah Input Gallery
        function addGalleryInput() {
            const div = document.createElement('div');
            div.className = 'd-flex align-items-center gap-2 mb-2 position-relative';
            div.innerHTML = `
                <input type="file" name="foto_barang[]" class="form-control" accept="image/*" onchange="previewImage(this)">
                <div style="width:50px; height:50px; background:#eee; border-radius:8px; overflow:hidden; display:none;"><img src="" style="width:100%; height:100%; object-fit:cover;"></div>
                <button type="button" class="btn btn-danger btn-sm rounded-circle" style="width:30px; height:30px; padding:0;" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            `;
            document.getElementById('gallery-container').appendChild(div);
        }

        // 2. Fungsi Tambah Input Parts
        function addPartInput() {
            const div = document.createElement('div');
            div.className = 'item-part-card';
            div.innerHTML = `
                <button type="button" class="btn-remove-part" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="small fw-bold text-primary">Nama Part / Item *</label>
                        <input type="text" name="items[${itemIndex}][name]" class="form-control" placeholder="Nama Part" required>
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold text-primary">Foto Part</label>
                        <div class="d-flex gap-2">
                            <input type="file" name="items[${itemIndex}][image]" class="form-control" onchange="previewImage(this)">
                            <div style="width:40px; height:40px; background:#eee; border-radius:5px; overflow:hidden; display:none;"><img src="" style="width:100%; height:100%; object-fit:cover;"></div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3"><label class="small text-muted">Tipe / Series</label><input type="text" name="items[${itemIndex}][tipe]" class="form-control"></div>
                    <div class="col-6 col-md-3"><label class="small text-muted">Dimensi (mm)</label><input type="text" name="items[${itemIndex}][dimensi]" class="form-control"></div>
                    <div class="col-6 col-md-3"><label class="small text-muted">Konfigurasi</label><input type="text" name="items[${itemIndex}][konfigurasi]" class="form-control"></div>
                    <div class="col-6 col-md-3"><label class="small text-muted">Load Capacity</label><input type="text" name="items[${itemIndex}][load]" class="form-control"></div>
                </div>
            `;
            document.getElementById('items-container').appendChild(div);
            itemIndex++;
        }

       // 3. Fungsi Tambah Input Project (DENGAN INPUT TEMPAT)
        function addProjectInput() {
            const div = document.createElement('div');
            div.className = 'row g-2 mb-2 align-items-center position-relative'; 
            div.innerHTML = `
                <div class="col-5">
                    <input type="text" name="project_places[]" class="form-control" placeholder="Nama Tempat / Lokasi">
                </div>
                <div class="col-6">
                    <input type="file" name="project_images[]" class="form-control" accept="image/*" onchange="previewImage(this)">
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-danger btn-sm rounded-circle" style="width:30px; height:30px; padding:0;" onclick="this.closest('.row').remove()"><i class="fas fa-times"></i></button>
                </div>
                <div class="col-12 mt-1" style="display:none;">
                     <div style="width:60px; height:60px; background:#eee; border-radius:8px; overflow:hidden;">
                        <img src="" style="width:100%; height:100%; object-fit:cover;">
                     </div>
                </div>
            `;
            document.getElementById('project-container').appendChild(div);
        }

        // 4. Fungsi Preview Gambar (Universal)
        function previewImage(input) {
            const file = input.files[0];
            const previewBox = input.nextElementSibling; // Div kosong di sebelah input
            if(previewBox && file) {
                const img = previewBox.querySelector('img');
                const reader = new FileReader();
                reader.onload = function(e){ img.src = e.target.result; previewBox.style.display = 'block'; }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>