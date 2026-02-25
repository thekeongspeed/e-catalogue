<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Spesifikasi - {{ $product->nama_barang ?? 'Produk' }}</title>
    <link rel="icon" href="{{ asset('bg-watermark.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('bg-watermark.png') }}" type="image/x-icon">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* STYLE STANDARD */
        body { font-family: 'Poppins', sans-serif; background-color: #f9f9f9; position: relative; min-height: 100vh; padding-bottom: 50px; }
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
        .navbar-custom { background-color: #1a459c; padding: 15px 25px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin-bottom: 30px; }
        .btn-back { color: white; font-size: 24px; text-decoration: none; }
        .header-title { color: white; font-weight: 600; font-size: 18px; text-transform: uppercase; }
        
        .section-card { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 15px rgba(0,0,0,0.03); margin: 0 auto 25px auto; border: 1px solid #f0f0f0; max-width: 800px; }
        .section-label { font-size: 16px; font-weight: 600; color: #1a459c; margin-bottom: 15px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; }
        
        .form-control { border-radius: 10px; border: 1px solid #ddd; padding: 10px 15px; font-size: 14px; }

        .existing-img-wrapper { position: relative; width: 100px; height: 100px; border-radius: 10px; overflow: hidden; border: 2px solid #eee; background: white; }
        .existing-img-wrapper img { width: 100%; height: 100%; object-fit: cover; }
        .delete-overlay { position: absolute; inset: 0; background: rgba(220,53,69,0.9); color: white; display: flex; align-items: center; justify-content: center; font-size: 12px; opacity: 0; transition: 0.2s; cursor: pointer; }
        
        .del-check:checked + img + .delete-overlay { opacity: 1; }
        .del-check { position: absolute; top: 5px; right: 5px; z-index: 10; accent-color: red; width: 16px; height: 16px; cursor: pointer; }

        .btn-action-group { display: flex; justify-content: flex-end; gap: 10px; margin-top: 30px; }
        .btn-custom { border: none; border-radius: 50px; padding: 12px 30px; font-weight: 600; font-size: 14px; }
        .btn-batal { background-color: #dc1f26; color: white; text-decoration: none; display: inline-flex; align-items: center; }
        .btn-simpan { background-color: #1a459c; color: white; }

        /* --- STYLE INPUT GROUP (KIRI & KANAN) --- */
        .input-group-text { background-color: #f8f9fa; border: 1px solid #dee2e6; color: #1a459c; }
        
        /* Ikon di Kiri (Contoh: Rp) */
        .input-group .input-group-text:first-child { border-right: none; }
        .input-group .input-group-text:first-child + .form-control { border-left: none; }

        /* Ikon di Kanan (Contoh: mm) */
        .input-group .form-control:not(:last-child) { border-right: none; }
        .input-group .form-control:not(:last-child) + .input-group-text { border-left: none; font-size: 12px; font-weight: bold; }

        /* Efek Focus */
        .input-group:focus-within .input-group-text, .input-group:focus-within .form-control { border-color: #1a459c; background-color: #eef2ff; }
        .input-group:focus-within .form-control { box-shadow: none; background-color: #fff; }
    </style>
</head>
<body>

    <div class="navbar-custom d-flex align-items-center">
        <a href="/detail/{{ $product->id ?? '' }}" class="btn-back me-3"><i class="fas fa-arrow-left"></i></a>
        <div class="header-title">Edit Spesifikasi</div>
    </div>

    <div class="container">
        <form action="/update-spec/{{ $product->id ?? '' }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="section-card">
                <div class="section-label"><i class="fas fa-info-circle me-2"></i> Informasi Dasar</div>
                <div class="row g-3">
                    <div class="col-md-6"><label class="small fw-bold text-muted">Nama Customer</label><input type="text" name="nama_customer" class="form-control" value="{{ $product->nama_customer ?? '' }}"></div>
                    <div class="col-md-6"><label class="small fw-bold text-muted">Nama Barang</label><input type="text" name="nama_barang" class="form-control" value="{{ $product->nama_barang ?? '' }}"></div>
                    <div class="col-md-4"><label class="small fw-bold text-muted">Material</label><input type="text" name="jenis_material" class="form-control" value="{{ $product->jenis_material ?? '' }}"></div>
                    <div class="col-md-4"><label class="small fw-bold text-muted">Finishing</label><input type="text" name="finishing" class="form-control" value="{{ $product->finishing ?? '' }}"></div>
                    <div class="col-md-4"><label class="small fw-bold text-muted">Tipe</label><input type="text" name="tipe" class="form-control" value="{{ $product->tipe ?? '' }}"></div>

                    <div class="col-md-6">
                        <label class="small fw-bold text-muted">Color Available</label>
                        <input type="text" name="color_available" class="form-control" value="{{ $product->color_available ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold text-muted">Price (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text fw-bold">Rp</span>
                            <input type="text" class="form-control" 
                                   value="{{ !empty($product->price) ? number_format($product->price, 0, ',', '.') : '' }}" 
                                   onkeyup="formatRupiah(this)">
                            <input type="hidden" name="price" id="price_actual" value="{{ $product->price ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-card mt-4">
                <div class="section-label"><i class="fas fa-ruler-combined me-2"></i> Dimensi Produk</div>
                <table class="table table-borderless align-middle" id="dimensiTable">
                    <thead>
                        <tr class="border-bottom">
                            <th style="width: 15%">Item Code</th>
                            <th>Panjang</th> <th>Lebar</th> <th>Tinggi</th> <th>Kedalaman</th> <th>Hapus</th>
                        </tr>
                    </thead>


                  <tbody>
                        @if(isset($dimensions) && count($dimensions) > 0)
                            @foreach($dimensions as $dim)
                            <tr>
                                <td><input type="text" name="dim_item_code[]" class="form-control" value="{{ $dim->item_code ?? '' }}" placeholder="Code"></td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="dim_panjang[]" class="form-control" value="{{ $dim->panjang ?? '' }}">
                                        <span class="input-group-text">mm</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="dim_lebar[]" class="form-control" value="{{ $dim->lebar ?? '' }}">
                                        <span class="input-group-text">mm</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="dim_tinggi[]" class="form-control" value="{{ $dim->tinggi ?? '' }}">
                                        <span class="input-group-text">mm</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="dim_kedalaman[]" class="form-control" value="{{ $dim->kedalaman ?? '' }}">
                                        <span class="input-group-text">mm</span>
                                    </div>
                                </td>
                                <td class="text-center"><button type="button" class="btn btn-danger btn-sm rounded-circle" onclick="removeRow(this)"><i class="fas fa-trash"></i></button></td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td><input type="text" name="dim_item_code[]" class="form-control" placeholder="Code"></td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="dim_panjang[]" class="form-control" placeholder="0">
                                        <span class="input-group-text">mm</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="dim_lebar[]" class="form-control" placeholder="0">
                                        <span class="input-group-text">mm</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="dim_tinggi[]" class="form-control" placeholder="0">
                                        <span class="input-group-text">mm</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="dim_kedalaman[]" class="form-control" placeholder="0">
                                        <span class="input-group-text">mm</span>
                                    </div>
                                </td>
                                <td class="text-center"><button type="button" class="btn btn-danger btn-sm rounded-circle" onclick="removeRow(this)"><i class="fas fa-trash"></i></button></td>
                            </tr>
                        @endif
                    </tbody>


                </table>
                <button type="button" class="btn btn-success btn-sm mt-2" onclick="addDimensiRow()"><i class="fas fa-plus me-1"></i> Tambah Variasi Ukuran</button>
            </div>
<div class="section-card">
        <div class="section-label"><i class="fas fa-images me-2"></i> Foto Gallery</div>

        
       @if(count($gallery) > 0)
        <label class="small fw-bold text-muted mb-2">Foto Saat Ini (Centang kotak merah untuk menghapus)</label>
        <div class="row g-3 mb-4">
            @foreach($gallery as $img)
            <div class="col-6 col-md-4 col-lg-3">
                
                <div style="position: relative; width: 100%; height: 130px; border: 2px solid #eee; border-radius: 10px; background-color: #ffffff; display: flex; align-items: center; justify-content: center; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    
                    <img src="{{ asset('storage/' . $img->image_path) }}" style="max-width: 90%; max-height: 90%; object-fit: contain;">
                    
                    <div style="position: absolute; top: 5px; left: 5px; background: white; padding: 3px 6px; border-radius: 5px; border: 1px solid #ddd;">
                        <input class="form-check-input border-danger m-0" type="checkbox" name="delete_gallery_ids[]" value="{{ $img->id }}" style="cursor: pointer; width: 16px; height: 16px;">
                    </div>

                </div>

            </div>
            @endforeach
        </div>
        @endif


        
        <label class="small fw-bold text-muted mt-2 mb-2 border-top pt-3 d-block">Tambah Foto Baru</label>
        
        <div id="gallery-container">
            <div class="d-flex align-items-center gap-2 mb-2 row-container">
                <input type="file" name="foto_barang_baru[]" class="form-control" accept="image/*" onchange="previewImage(this)">
                <div class="preview-box" style="width:40px; height:40px; background:#eee; border-radius:5px; overflow:hidden; display:none; flex-shrink: 0;">
                    <img src="" style="width:100%; height:100%; object-fit:cover;">
                </div>
            </div>
        </div>
        
        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill mt-2" onclick="addGalleryInput()">
            <i class="fas fa-plus"></i> Tambah Foto Lain
        </button>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4 mb-5">
        <a href="/detail/{{ $product->id }}" class="btn btn-secondary rounded-pill px-4">Batal</a>
        <button type="submit" class="btn btn-success rounded-pill px-4">
            <i class="fas fa-save me-2"></i> Simpan Perubahan
        </button>
    </div>
</form>


    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

      // 1. Jika Berhasil (Success)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                toast: true, /* Notif melayang di pojok */
                position: 'top-end',
                background: '#ffffff',
                color: '#1a459c'
            });
        @endif

        // 2. Jika Gagal/Ada Input yang Salah (Error)
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops! Ada yang salah',
                html: `
                    <ul style="text-align: left; margin-bottom: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `,
                confirmButtonColor: '#dc1f26'
            });
        @endif


        // Preview Gambar
      function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var container = input.closest('.row-container');
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


        //Fungsi Tambah Baris Gallery Baru (Seperti di input.blade.php)
    function addGalleryInput() {
        const div = document.createElement('div');
        div.className = 'd-flex align-items-center gap-2 mb-2 row-container';
        div.innerHTML = `
            <input type="file" name="foto_barang_baru[]" class="form-control" accept="image/*" onchange="previewImage(this)">
            <div class="preview-box" style="width:40px; height:40px; background:#eee; border-radius:5px; overflow:hidden; display:none; flex-shrink: 0;">
                <img src="" style="width:100%; height:100%; object-fit:cover;">
            </div>
            <button type="button" class="btn btn-outline-danger btn-sm rounded-circle px-2" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        `;
        document.getElementById('gallery-container').appendChild(div);
    }
    

        // Tambah Baris Dimensi
      // Tambah Baris Dimensi
        function addDimensiRow() {
            let tbody = document.getElementById('dimensiTable').getElementsByTagName('tbody')[0];
            let newRow = tbody.insertRow();
            newRow.innerHTML = `
                <td><input type="text" name="dim_item_code[]" class="form-control" placeholder="Code"></td>
                <td>
                    <div class="input-group">
                        <input type="number" step="0.01" name="dim_panjang[]" class="form-control" placeholder="0">
                        <span class="input-group-text">mm</span>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <input type="number" step="0.01" name="dim_lebar[]" class="form-control" placeholder="0">
                        <span class="input-group-text">mm</span>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <input type="number" step="0.01" name="dim_tinggi[]" class="form-control" placeholder="0">
                        <span class="input-group-text">mm</span>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <input type="number" step="0.01" name="dim_kedalaman[]" class="form-control" placeholder="0">
                        <span class="input-group-text">mm</span>
                    </div>
                </td>
                <td class="text-center"><button type="button" class="btn btn-danger btn-sm rounded-circle" onclick="removeRow(this)"><i class="fas fa-trash"></i></button></td>
            `;
        }
        

        // Hapus Baris Dimensi
        function removeRow(btn) {
            let row = btn.closest('tr');
            if (row.parentElement.rows.length > 1) row.remove();
        }

        // Format Rupiah
        function formatRupiah(input) {
            let value = input.value.replace(/[^0-9]/g, '');
            if (!value) {
                input.value = '';
                document.getElementById('price_actual').value = '';
                return;
            }
            document.getElementById('price_actual').value = value;
            input.value = parseInt(value).toLocaleString('id-ID');
        }
    </script>
</body>
</html>