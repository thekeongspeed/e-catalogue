<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Katalog: {{ $product->nama_barang }}</title>
    <title>E-Catalogue UT</title>
    <link rel="icon" href="{{ asset('bg-watermark.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('bg-watermark.png') }}" type="image/x-icon">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* GUNAKAN STYLE YANG SAMA PERSIS DENGAN INPUT.BLADE.PHP */
        body { font-family: 'Poppins', sans-serif; background-color: #f9f9f9; position: relative; min-height: 100vh; }
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
        .navbar-custom { background-color: #1a459c; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .btn-home { color: white; font-size: 24px; text-decoration: none; }
        .btn-logout { background-color: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); padding: 8px 25px; border-radius: 50px; font-weight: 500; text-decoration: none; font-size: 14px; }
        .page-title { font-size: 22px; font-weight: 600; margin: 30px 0 20px 0; color: #333; }
        .section-card { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 15px rgba(0,0,0,0.03); margin-bottom: 25px; border: 1px solid #f0f0f0; }
        .section-label { font-size: 16px; font-weight: 600; color: #1a459c; margin-bottom: 15px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; }
        .form-control { border-radius: 10px; border: 1px solid #ddd; padding: 10px 15px; font-size: 14px; }
        .form-control:focus { border-color: #1a459c; box-shadow: 0 0 0 3px rgba(26, 69, 156, 0.1); }
        .item-part-card { background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 12px; padding: 15px; margin-bottom: 15px; position: relative; }
        .btn-remove-part { position: absolute; top: -10px; right: -10px; width: 30px; height: 30px; border-radius: 50%; background: #dc3545; color: white; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
        .btn-action-group { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; margin-bottom: 50px; }
        .btn-custom { border: none; border-radius: 50px; padding: 12px 40px; font-weight: 600; font-size: 15px; min-width: 140px; }
        .btn-batal { background-color: #dc1f26; color: white; text-decoration: none; text-align: center; }
        .btn-tambah { background-color: #e8a626; color: white; } /* Warna Orange untuk Update */
        .btn-tambah:hover { background-color: #d1931c; color: white; }

        /* Style khusus untuk Edit Gallery */
        .existing-gallery-item { position: relative; width: 80px; height: 80px; border-radius: 8px; overflow: hidden; border: 2px solid #eee; }
        .existing-gallery-item img { width: 100%; height: 100%; object-fit: cover; }
        .btn-delete-gallery { position: absolute; top: 2px; right: 2px; background: rgba(220, 53, 69, 0.8); color: white; border: none; border-radius: 50%; width: 20px; height: 20px; font-size: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center;}
        .gallery-deleted-overlay { position: absolute; inset: 0; background: rgba(220, 53, 69, 0.7); color: white; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold; display: none;}
    </style>
</head>
<body>

    <div class="navbar-custom">
        <a href="/" class="btn-home"><i class="fas fa-home"></i></a>
        <a href="/logout" class="btn-logout">Logout</a>
    </div>

    <div class="container">
        <div class="page-title">Edit Katalog: <span class="text-primary">{{ $product->nama_barang }}</span></div>

        @if ($errors->any()) <div class="alert alert-danger rounded-3 shadow-sm border-0"><ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul></div> @endif

        <form action="/update/{{ $product->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <div class="section-card">
                <div class="section-label"><i class="fas fa-info-circle me-2"></i> Informasi Dasar</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="small fw-bold text-muted">Nama Customer</label>
                        <input type="text" name="nama_customer" class="form-control" value="{{ $product->nama_customer }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold text-muted">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" value="{{ $product->nama_barang }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold text-muted">Material Utama</label>
                        <input type="text" name="jenis_material" class="form-control" value="{{ $product->jenis_material }}">
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold text-muted">Finishing / Warna</label>
                        <input type="text" name="finishing" class="form-control" value="{{ $product->finishing }}">
                    </div>
                </div>
            </div>

            <div class="section-card">
                <div class="section-label"><i class="fas fa-ruler-combined me-2"></i> Dimensi Produk Utama</div>
                <div class="row g-3">
                    <div class="col-6 col-md-3"><label class="small text-muted">Panjang (cm)</label><input type="number" step="0.01" name="panjang" class="form-control" value="{{ $product->panjang }}"></div>
                    <div class="col-6 col-md-3"><label class="small text-muted">Lebar (cm)</label><input type="number" step="0.01" name="lebar" class="form-control" value="{{ $product->lebar }}"></div>
                    <div class="col-6 col-md-3"><label class="small text-muted">Tinggi (cm)</label><input type="number" step="0.01" name="tinggi" class="form-control" value="{{ $product->tinggi }}"></div>
                    <div class="col-6 col-md-3"><label class="small text-muted">Kedalaman (cm)</label><input type="number" step="0.01" name="kedalaman" class="form-control" value="{{ $product->kedalaman }}"></div>
                </div>
            </div>

            <div class="section-card">
                <div class="section-label"><i class="fas fa-images me-2"></i> Foto Gallery (Slideshow)</div>
                
                <p class="small fw-bold text-muted mb-2">Foto Saat Ini (Klik X untuk menghapus):</p>
                <div class="d-flex gap-2 flex-wrap mb-4">
                    @foreach($gallery as $img)
                    <div class="existing-gallery-item" id="gallery-item-{{ $img->id }}">
                        <img src="{{ asset('storage/' . $img->image_path) }}">
                        <button type="button" class="btn-delete-gallery" onclick="markGalleryForDeletion({{ $img->id }})">X</button>
                        <div class="gallery-deleted-overlay text-center"><i class="fas fa-trash me-1"></i> Dihapus</div>
                    </div>
                    @endforeach
                </div>
                <div id="deleted-gallery-inputs"></div>


                <p class="small fw-bold text-muted mb-2">Tambah Foto Baru:</p>
                <div id="gallery-container">
                    </div>
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill mt-2" onclick="addGalleryInput()">
                    <i class="fas fa-plus me-1"></i> Tambah Foto Lain
                </button>
            </div>

            <div class="section-card">
                <div class="section-label"><i class="fas fa-cubes me-2"></i> Komponen Parts</div>
                <p class="small text-muted mb-3">Edit komponen yang ada atau tambahkan yang baru.</p>
                
                <div id="items-container">
                    @foreach($items as $index => $item)
                    <div class="item-part-card">
                        <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                        
                        <button type="button" class="btn-remove-part" onclick="this.closest('.item-part-card').remove()"><i class="fas fa-times"></i></button>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="small fw-bold text-primary">Nama Part / Item *</label>
                                <input type="text" name="items[{{ $index }}][name]" class="form-control" value="{{ $item->nama_item }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-primary">Ganti Foto Part (Opsional)</label>
                                <div class="d-flex gap-2">
                                    <input type="file" name="items[{{ $index }}][image]" class="form-control" onchange="previewImage(this)">
                                    <div style="width:40px; height:40px; background:#eee; border-radius:5px; overflow:hidden;">
                                        <img src="{{ $item->foto_item ? asset('storage/'.$item->foto_item) : '' }}" style="width:100%; height:100%; object-fit:cover; display: {{ $item->foto_item ? 'block' : 'none' }};">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3"><label class="small text-muted">Tipe / Series</label><input type="text" name="items[{{ $index }}][tipe]" class="form-control" value="{{ $item->tipe }}"></div>
                            <div class="col-6 col-md-3"><label class="small text-muted">Dimensi Part</label><input type="text" name="items[{{ $index }}][dimensi]" class="form-control" value="{{ $item->dimensi_part }}"></div>
                            <div class="col-6 col-md-3"><label class="small text-muted">Konfigurasi</label><input type="text" name="items[{{ $index }}][konfigurasi]" class="form-control" value="{{ $item->konfigurasi }}"></div>
                            <div class="col-6 col-md-3"><label class="small text-muted">Load Capacity</label><input type="text" name="items[{{ $index }}][load]" class="form-control" value="{{ $item->load_capacity }}"></div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill w-100" onclick="addPartInput()">
                    <i class="fas fa-plus-circle me-1"></i> Tambah Komponen Baru
                </button>
            </div>


            <div class="section-card">
                <div class="section-label"><i class="fas fa-hard-hat me-2"></i> Project Reference</div>
                
                <p class="small fw-bold text-muted mb-2">Dokumentasi Saat Ini:</p>
                <div class="d-flex gap-2 flex-wrap mb-4">
                    @forelse($projects as $proj)
                    <div class="existing-gallery-item" id="project-item-{{ $proj->id }}">
                        <img src="{{ asset('storage/' . $proj->image_path) }}">
                        <button type="button" class="btn-delete-gallery" onclick="markProjectForDeletion({{ $proj->id }})">X</button>
                        <div class="gallery-deleted-overlay text-center"><i class="fas fa-trash me-1"></i> Hapus</div>
                    </div>
                    @empty
                        <div class="text-muted small fst-italic">Belum ada foto project.</div>
                    @endforelse
                </div>
                <div id="deleted-project-inputs"></div>

                <p class="small fw-bold text-muted mb-2">Tambah Dokumentasi Baru:</p>
                <div id="project-container"></div>
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill mt-2" onclick="addProjectInput()">
                    <i class="fas fa-plus me-1"></i> Tambah Foto Project
                </button>
            </div>


            <div class="btn-action-group">
                <a href="/detail/{{ $product->id }}" class="btn-custom btn-batal">Batal</a>
                <button type="submit" class="btn-custom btn-tambah">Simpan Perubahan</button>
            </div>
        </form>
    </div>

    <script>
        // Hitung index awal berdasarkan jumlah item yang sudah ada agar tidak bentrok
        let itemIndex = {{ count($items) + 1 }};

        // Fungsi untuk menandai foto galeri lama untuk dihapus
        function markGalleryForDeletion(id) {
            const container = document.getElementById('deleted-gallery-inputs');
            // Tambahkan hidden input dengan name="delete_gallery_ids[]"
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'delete_gallery_ids[]';
            input.value = id;
            container.appendChild(input);
            
            // Tampilkan overlay "Dihapus" secara visual
            const itemDiv = document.getElementById('gallery-item-' + id);
            itemDiv.querySelector('.gallery-deleted-overlay').style.display = 'flex';
            itemDiv.querySelector('.btn-delete-gallery').style.display = 'none';
        }

        function addGalleryInput() {
            // GUNAKAN NAME YANG BEDA: foto_barang_baru[]
            const div = document.createElement('div');
            div.className = 'd-flex align-items-center gap-2 mb-2 position-relative';
            div.innerHTML = `
                <input type="file" name="foto_barang_baru[]" class="form-control" accept="image/*" onchange="previewImage(this)">
                <div style="width:50px; height:50px; background:#eee; border-radius:8px; overflow:hidden; display:none;"><img src="" style="width:100%; height:100%; object-fit:cover;"></div>
                <button type="button" class="btn btn-danger btn-sm rounded-circle" style="width:30px; height:30px; padding:0;" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            `;
            document.getElementById('gallery-container').appendChild(div);
        }

        function addPartInput() {
            const div = document.createElement('div');
            div.className = 'item-part-card bg-white border-primary'; // Beda warna dikit biar tau ini item baru
            // Item baru TIDAK PUNYA hidden input ID
            div.innerHTML = `
                <button type="button" class="btn-remove-part" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
                <div class="row g-3">
                    <div class="col-md-6"><label class="small fw-bold text-primary">Nama Part / Item * (BARU)</label><input type="text" name="items[${itemIndex}][name]" class="form-control" placeholder="Nama Part Baru" required></div>
                    <div class="col-md-6"><label class="small fw-bold text-primary">Foto Part</label><div class="d-flex gap-2"><input type="file" name="items[${itemIndex}][image]" class="form-control" onchange="previewImage(this)"><div style="width:40px; height:40px; background:#eee; border-radius:5px; overflow:hidden; display:none;"><img src="" style="width:100%; height:100%; object-fit:cover;"></div></div></div>
                    <div class="col-6 col-md-3"><label class="small text-muted">Tipe / Series</label><input type="text" name="items[${itemIndex}][tipe]" class="form-control"></div>
                    <div class="col-6 col-md-3"><label class="small text-muted">Dimensi Part</label><input type="text" name="items[${itemIndex}][dimensi]" class="form-control"></div>
                    <div class="col-6 col-md-3"><label class="small text-muted">Konfigurasi</label><input type="text" name="items[${itemIndex}][konfigurasi]" class="form-control"></div>
                    <div class="col-6 col-md-3"><label class="small text-muted">Load Capacity</label><input type="text" name="items[${itemIndex}][load]" class="form-control"></div>
                </div>
            `;
            document.getElementById('items-container').appendChild(div);
            itemIndex++;
        }

        function previewImage(input) {
            const file = input.files[0];
            const previewBox = input.nextElementSibling;
            if(previewBox && file) {
                const img = previewBox.querySelector('img');
                const reader = new FileReader();
                reader.onload = function(e){ img.src = e.target.result; previewBox.style.display = 'block'; }
                reader.readAsDataURL(file);
            }
        }

        // Fungsi tandai hapus project
        function markProjectForDeletion(id) {
            const container = document.getElementById('deleted-project-inputs');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'delete_project_ids[]';
            input.value = id;
            container.appendChild(input);
            
            const itemDiv = document.getElementById('project-item-' + id);
            itemDiv.querySelector('.gallery-deleted-overlay').style.display = 'flex';
            itemDiv.querySelector('.btn-delete-gallery').style.display = 'none';
        }

        // Fungsi tambah input project (Name: project_images_baru[])
        function addProjectInput() {
            const div = document.createElement('div');
            div.className = 'd-flex align-items-center gap-2 mb-2 position-relative';
            div.innerHTML = `
                <input type="file" name="project_images_baru[]" class="form-control" accept="image/*" onchange="previewImage(this)">
                <div style="width:50px; height:50px; background:#eee; border-radius:8px; overflow:hidden; display:none;"><img src="" style="width:100%; height:100%; object-fit:cover;"></div>
                <button type="button" class="btn btn-danger btn-sm rounded-circle" style="width:30px; height:30px; padding:0;" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            `;
            document.getElementById('project-container').appendChild(div);
        }

        
    </script>
</body>
</html>