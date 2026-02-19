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

        input[list]::-webkit-calendar-picker-indicator { color: #1a459c; opacity: 1; }



        /* --- STYLE TAMBAHAN UNTUK FORM YANG LEBIH CANTIK --- */
.form-label-custom {
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6c757d;
    margin-bottom: 5px;
    display: block;
}

.input-group-text {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-right: none;
    color: #1a459c; /* Warna Biru Brand */
}

.form-control {
    border: 1px solid #dee2e6;
    border-left: none; /* Hilangkan border kiri biar nyatu sama ikon */
    padding: 10px 15px;
    font-size: 14px;
    transition: all 0.3s;
}

/* Efek saat input diklik */
.input-group:focus-within .input-group-text {
    border-color: #1a459c;
    background-color: #eef2ff;
}

.input-group:focus-within .form-control {
    border-color: #1a459c;
    box-shadow: 0 0 0 3px rgba(26, 69, 156, 0.1);
}

/* Judul Section yang lebih fresh */
.section-header-modern {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px dashed #e0e0e0;
}
.section-title {
    font-size: 16px;
    font-weight: 700;
    color: #333;
}


    </style>


</head>
<body>

    <div class="navbar-custom">
        <a href="/" class="btn-home"><i class="fas fa-home"></i></a>
        <a href="/logout" class="btn-logout">Logout</a>
    </div>
<div class="container py-4" style="max-width: 900px;">
        <h3 class="mb-4">Tambah Katalog Baru</h3>

        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if($errors->any()) <div class="alert alert-danger"><ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul></div> @endif

        <form action="/store" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="section-card">
           <div class="section-header-modern">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                        <i class="fas fa-info"></i>
                    </div>
                    <div class="section-title">Informasi Utama Produk</div>
                </div>

                <div class="row g-4">
                   <div class="col-md-6">
                            <label class="form-label-custom">Nama Customer</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                <input class="form-control" list="customerOptions" name="nama_customer" placeholder="Pilih..." required autocomplete="off">
                                
                                <a href="/customers" class="btn btn-outline-secondary" title="Kelola Customer" target="_blank">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>
                            
                            <datalist id="customerOptions">
                                @foreach($customerList as $cust)
                                    <option value="{{ $cust->name }}">
                                @endforeach
                            </datalist>
                        </div>
                        

                    <div class="col-md-6">
                        <label class="form-label-custom">Nama Barang</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-box"></i></span>
                            <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Rak Gondola T30" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label-custom">Tipe / Series</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                            <input type="text" name="tipe" class="form-control" placeholder="Contoh: UT 5">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label-custom">Material Utama</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                            <input type="text" name="jenis_material" class="form-control" placeholder="Contoh: Steel SS400">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label-custom">Finishing</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-paint-roller"></i></span>
                            <input type="text" name="finishing" class="form-control" placeholder="Contoh: Powder Coating">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label-custom">Warna Tersedia (Color Available)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-palette"></i></span>
                            <input type="text" name="color_available" class="form-control" placeholder="Contoh: Red, Blue, Black">
                        </div>
                    </div>

                   <div class="col-md-6">
                        <label class="form-label-custom">Estimasi Harga (Price)</label>
                        <div class="input-group">
                            <span class="input-group-text fw-bold">Rp</span>
                            
                            <input type="text" id="price_display" class="form-control" placeholder="0" onkeyup="formatRupiah(this)">
                            
                            <input type="hidden" name="price" id="price_actual">
                        </div>
                      
                    </div>
                </div>
            </div>


            <div class="section-card">
                <div class="section-label"><i class="fas fa-ruler-combined me-2"></i> Dimensi Produk</div>
                <table class="table table-borderless" id="dimensiTable">
                    <thead>
                        <tr class="border-bottom">
                            <th style="width: 20%">Item Code</th>
                            <th>Panjang</th> <th>Lebar</th> <th>Tinggi</th> <th>Kedalaman</th> <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="dim_item_code[]" class="form-control" placeholder="Code"></td>
                            <td><input type="number" name="dim_panjang[]" class="form-control" placeholder="P"></td>
                            <td><input type="number" name="dim_lebar[]" class="form-control" placeholder="L"></td>
                            <td><input type="number" name="dim_tinggi[]" class="form-control" placeholder="T"></td>
                            <td><input type="number" name="dim_kedalaman[]" class="form-control" placeholder="D"></td>
                            <td><button type="button" class="btn btn-danger btn-sm rounded-circle" onclick="removeRow(this)"><i class="fas fa-trash"></i></button></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill" onclick="addDimensiRow()"><i class="fas fa-plus"></i> Tambah Ukuran</button>
            </div>

            <div class="section-card">
                <div class="section-label"><i class="fas fa-images me-2"></i> Foto Gallery</div>
                <div id="gallery-container">
                    <div class="d-flex align-items-center gap-2 mb-2 row-container">
                        <input type="file" name="foto_barang[]" class="form-control" accept="image/*" onchange="previewImage(this)">
                        <div class="preview-box" style="width:50px; height:50px; background:#eee; border-radius:8px; overflow:hidden; display:none;">
                            <img src="" style="width:100%; height:100%; object-fit:cover;">
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill mt-2" onclick="addGalleryInput()"><i class="fas fa-plus"></i> Tambah Foto Lain</button>
            </div>

            <div class="section-card">
                <div class="section-label"><i class="fas fa-cubes me-2"></i> Komponen Parts</div>
                <div id="items-container">
                    <div class="item-part-card row-container">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="small fw-bold text-primary">Nama Part (Optional)</label>
                                <input type="text" name="items[0][name]" class="form-control"> 
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-primary">Foto Part</label>
                                <div class="d-flex gap-2 align-items-center">
                                    <input type="file" name="items[0][image]" class="form-control" onchange="previewImage(this)">
                                    <div class="preview-box" style="width:40px; height:40px; background:#eee; border-radius:5px; overflow:hidden; display:none;">
                                        <img src="" style="width:100%; height:100%; object-fit:cover;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3"><label>Tipe</label><input type="text" name="items[0][tipe]" class="form-control"></div>
                            <div class="col-6 col-md-3"><label>Dimensi</label><input type="text" name="items[0][dimensi]" class="form-control"></div>
                            <div class="col-6 col-md-3"><label>Konfigurasi</label><input type="text" name="items[0][konfigurasi]" class="form-control"></div>
                            <div class="col-6 col-md-3"><label>Load</label><input type="text" name="items[0][load]" class="form-control"></div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill w-100" onclick="addPartInput()"><i class="fas fa-plus-circle"></i> Tambah Komponen</button>
            </div>

            <div class="section-card">
                <div class="section-label"><i class="fas fa-hard-hat me-2"></i> Project Reference</div>
                <div id="project-container">
                    <div class="row g-2 mb-2 align-items-center position-relative row-container">
                        <div class="col-5"><input type="text" name="project_places[]" class="form-control" placeholder="Nama Tempat"></div>
                        <div class="col-6 d-flex gap-2 align-items-center">
                            <input type="file" name="project_images[]" class="form-control" accept="image/*" onchange="previewImage(this)">
                            <div class="preview-box" style="width:50px; height:50px; background:#eee; border-radius:8px; overflow:hidden; display:none; flex-shrink: 0;"><img src="" style="width:100%; height:100%; object-fit:cover;"></div>
                        </div>
                        <div class="col-1"><button type="button" class="btn btn-secondary btn-sm rounded-circle" disabled><i class="fas fa-times"></i></button></div>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill mt-2" onclick="addProjectInput()"><i class="fas fa-plus"></i> Tambah Project Lain</button>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="/" class="btn btn-secondary rounded-pill px-4">Batal</a>
                <button type="submit" class="btn btn-success rounded-pill px-4">Simpan Katalog</button>
            </div>
        </form>
    </div>






    <script>
        let itemIndex = 1;

        // FUNGSI PREVIEW GAMBAR
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var container = input.closest('.row-container') || input.parentElement;
                    var img = container.querySelector('img');
                    var box = container.querySelector('.preview-box');
                    if(img && box) {
                        img.src = e.target.result;
                        box.style.display = 'block';
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // FUNGSI TAMBAH DIMENSI (UPDATE: ADA ITEM CODE)
        function addDimensiRow() {
            let tbody = document.getElementById('dimensiTable').getElementsByTagName('tbody')[0];
            let newRow = tbody.insertRow();
            newRow.innerHTML = `
                <td><input type="text" name="dim_item_code[]" class="form-control" placeholder="Code"></td>
                <td><input type="number" name="dim_panjang[]" class="form-control" placeholder="P"></td>
                <td><input type="number" name="dim_lebar[]" class="form-control" placeholder="L"></td>
                <td><input type="number" name="dim_tinggi[]" class="form-control" placeholder="T"></td>
                <td><input type="number" name="dim_kedalaman[]" class="form-control" placeholder="D"></td>
                <td><button type="button" class="btn btn-danger btn-sm rounded-circle" onclick="removeRow(this)"><i class="fas fa-trash"></i></button></td>
            `;
        }

        function removeRow(btn) {
            let row = btn.closest('tr');
            if (row.parentElement.rows.length > 1) row.remove();
        }

        // FUNGSI TAMBAH GALLERY
        function addGalleryInput() {
            const div = document.createElement('div');
            div.className = 'd-flex align-items-center gap-2 mb-2 row-container';
            div.innerHTML = `
                <input type="file" name="foto_barang[]" class="form-control" accept="image/*" onchange="previewImage(this)">
                <div class="preview-box" style="width:50px; height:50px; background:#eee; border-radius:8px; overflow:hidden; display:none;">
                    <img src="" style="width:100%; height:100%; object-fit:cover;">
                </div>
                <button type="button" class="btn btn-danger btn-sm rounded-circle" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            `;
            document.getElementById('gallery-container').appendChild(div);
        }

        // FUNGSI TAMBAH PART (UPDATE: NAMA OPTIONAL)
        function addPartInput() {
            const div = document.createElement('div');
            div.className = 'item-part-card row-container';
            div.innerHTML = `
                <button type="button" class="btn-remove-part" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
                <div class="row g-3">
                    <div class="col-md-6"><label class="small fw-bold text-primary">Nama Part (Optional)</label><input type="text" name="items[${itemIndex}][name]" class="form-control"></div>
                    <div class="col-md-6">
                        <label class="small fw-bold text-primary">Foto Part</label>
                        <div class="d-flex gap-2 align-items-center">
                            <input type="file" name="items[${itemIndex}][image]" class="form-control" onchange="previewImage(this)">
                            <div class="preview-box" style="width:40px; height:40px; background:#eee; border-radius:5px; overflow:hidden; display:none;"><img src="" style="width:100%; height:100%; object-fit:cover;"></div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3"><label>Tipe</label><input type="text" name="items[${itemIndex}][tipe]" class="form-control"></div>
                    <div class="col-6 col-md-3"><label>Dimensi</label><input type="text" name="items[${itemIndex}][dimensi]" class="form-control"></div>
                    <div class="col-6 col-md-3"><label>Konfigurasi</label><input type="text" name="items[${itemIndex}][konfigurasi]" class="form-control"></div>
                    <div class="col-6 col-md-3"><label>Load</label><input type="text" name="items[${itemIndex}][load]" class="form-control"></div>
                </div>
            `;
            document.getElementById('items-container').appendChild(div);
            itemIndex++;
        }

        function addProjectInput() {
            const div = document.createElement('div');
            div.className = 'row g-2 mb-2 align-items-center position-relative row-container';
            div.innerHTML = `
                <div class="col-5"><input type="text" name="project_places[]" class="form-control" placeholder="Nama Tempat"></div>
                <div class="col-6 d-flex gap-2 align-items-center">
                    <input type="file" name="project_images[]" class="form-control" accept="image/*" onchange="previewImage(this)">
                    <div class="preview-box" style="width:50px; height:50px; background:#eee; border-radius:8px; overflow:hidden; display:none; flex-shrink: 0;"><img src="" style="width:100%; height:100%; object-fit:cover;"></div>
                </div>
                <div class="col-1"><button type="button" class="btn btn-danger btn-sm rounded-circle" onclick="this.closest('.row').remove()"><i class="fas fa-times"></i></button></div>
            `;
            document.getElementById('project-container').appendChild(div);
        }
    

        // --- FUNGSI FORMAT RUPIAH (TITIK OTOMATIS) ---
        function formatRupiah(input) {
            // 1. Ambil value yang diketik, hapus semua karakter selain angka
            // Contoh: User ngetik "1.000.a" -> jadi "1000"
            let value = input.value.replace(/[^0-9]/g, '');

            // 2. Cek jika kosong
            if (!value) {
                input.value = '';
                document.getElementById('price_actual').value = '';
                return;
            }

            // 3. Simpan nilai MURNI (angka saja) ke input hidden
            // Ini yang akan dibaca oleh Controller Laravel
            document.getElementById('price_actual').value = value;

            // 4. Format tampilan agar ada titik ribuan
            // Fungsi toLocaleString('id-ID') otomatis ngasih titik ala Indonesia
            input.value = parseInt(value).toLocaleString('id-ID');
        }

    </script>
</body>
</html>