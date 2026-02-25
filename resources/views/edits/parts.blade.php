<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Parts - {{ $product->nama_barang }}</title>
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
            position: relative;
            min-height: 100vh;
            padding-bottom: 50px;
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
        .navbar-custom { background-color: #1a459c; padding: 15px 25px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin-bottom: 40px; }
        .btn-back { color: white; font-size: 24px; text-decoration: none; }
        .header-title { color: white; font-weight: 600; font-size: 18px; text-transform: uppercase; }

        .main-container { max-width: 900px; margin: 0 auto; }

        .item-part-card {
            background: white; border-radius: 12px; padding: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05); margin-bottom: 20px;
            border: 1px solid #e9ecef; position: relative;
        }
        .item-part-card.new-item { border-left: 5px solid #008a3c; }

        .form-control { border-radius: 8px; border: 1px solid #ddd; padding: 10px; font-size: 14px; }
        .form-control:focus { border-color: #1a459c; box-shadow: 0 0 0 3px rgba(26, 69, 156, 0.1); }
        .form-label { font-weight: 500; font-size: 13px; color: #666; margin-bottom: 5px; }

        .btn-remove-part {
            position: absolute; top: 15px; right: 15px;
            color: #dc3545; background: none; border: none; font-size: 18px;
            cursor: pointer; transition: 0.2s;
        }
        .btn-remove-part:hover { color: #a00; transform: scale(1.1); }

        .btn-action-group { display: flex; justify-content: flex-end; gap: 10px; margin-top: 30px; }
        .btn-custom { border: none; border-radius: 50px; padding: 12px 30px; font-weight: 600; font-size: 14px; }
        .btn-batal { background-color: #dc1f26; color: white; text-decoration: none; display: inline-flex; align-items: center; }
        .btn-simpan { background-color: #1a9c32; color: white; }

        /* --- STYLE INPUT GROUP (KIRI & KANAN) --- */
        .input-group-text { background-color: #f8f9fa; border: 1px solid #dee2e6; color: #1a459c; }
        .input-group .form-control:not(:last-child) { border-right: none; }
        .input-group .form-control:not(:last-child) + .input-group-text { border-left: none; font-size: 12px; font-weight: bold; }
        .input-group:focus-within .input-group-text, .input-group:focus-within .form-control { border-color: #1a459c; background-color: #eef2ff; }
        .input-group:focus-within .form-control { box-shadow: none; background-color: #fff; }

    </style>
</head>
<body>

    <div class="navbar-custom d-flex align-items-center">
        <a href="/detail/{{ $product->id }}" class="btn-back me-3"><i class="fas fa-arrow-left"></i></a>
        <div class="header-title">Edit Komponen Parts</div>
    </div>

    <div class="container main-container">
        <form action="/update-parts/{{ $product->id }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div id="items-container">
                @foreach($items as $index => $item)
                <div class="item-part-card">
                    <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                    
                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                        <span class="fw-bold text-primary">Part #{{ $index+1 }}</span>
                        <label class="text-danger small fw-bold" style="cursor: pointer;">
                            <input type="checkbox" name="delete_part_ids[]" value="{{ $item->id }}" class="me-1"> Hapus Part Ini
                        </label>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label">Nama Part</label>
                            <input type="text" name="items[{{ $index }}][name]" class="form-control" value="{{ $item->nama_item }}" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Foto (Upload jika ganti)</label>
                            <input type="file" name="items[{{ $index }}][image]" class="form-control">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            @if($item->foto_item)
                                <img src="{{ asset('storage/'.$item->foto_item) }}" class="rounded border" style="width: 45px; height: 45px; object-fit: cover;">
                            @endif
                        </div>
                        
                       <div class="col-6 col-md-3">
                            <label class="form-label">Tipe</label>
                            <input type="text" name="items[{{ $index }}][tipe]" class="form-control" value="{{ $item->tipe ?? '' }}">
                        </div>
                        
                        <div class="col-6 col-md-3">
                            <label class="form-label">Dimensi</label>
                            <div class="input-group">
                                <input type="text" name="items[{{ $index }}][dimensi]" class="form-control" value="{{ $item->dimensi_part ?? '' }}">
                                <span class="input-group-text">mm</span>
                            </div>
                        </div>
                        
                        <div class="col-6 col-md-3">
                            <label class="form-label">Konfigurasi</label>
                            <input type="text" name="items[{{ $index }}][konfigurasi]" class="form-control" value="{{ $item->konfigurasi ?? '' }}">
                        </div>
                        
                        <div class="col-6 col-md-3">
                            <label class="form-label">Beban / Load</label>
                            <div class="input-group">
                                <input type="text" name="items[{{ $index }}][load]" class="form-control" value="{{ $item->load_capacity ?? '' }}">
                                <span class="input-group-text">kg</span>
                            </div>
                        </div>
                    
                    
                    </div>
                </div>
                @endforeach
            </div>

            <button type="button" class="btn btn-outline-primary w-100 rounded-pill py-2 border-2 fw-bold mt-3" onclick="addPart()">
                <i class="fas fa-plus-circle me-1"></i> Tambah Part Baru
            </button>

            <div class="btn-action-group">
                <a href="/detail/{{ $product->id }}" class="btn-custom btn-batal">Batal</a>
                <button type="submit" class="btn-custom btn-simpan">Simpan Parts</button>
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


      // Deklarasi index awal berdasarkan jumlah part yang sudah ada
        let partIndex = {{ count($items ?? []) }}; 

        function addPart() {
            const div = document.createElement('div');
            // Menambahkan border hijau untuk membedakan part baru
            div.className = 'item-part-card mt-3'; 
            div.style.borderLeft = '4px solid #198754'; 

            div.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                    <span class="fw-bold text-success">Part Baru (New)</span>
                    <button type="button" class="btn-close text-danger" onclick="this.closest('.item-part-card').remove()"></button>
                </div>

                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label text-muted small fw-bold">Nama Part *</label>
                        <input type="text" name="new_items[${partIndex}][name]" class="form-control" placeholder="Nama Part" required>
                    </div>
                    <div class="col-md-7">
                        <label class="form-label text-muted small fw-bold">Foto Part</label>
                        <input type="file" name="new_items[${partIndex}][image]" class="form-control">
                    </div>
                    
                    <div class="col-6 col-md-3">
                        <label class="form-label text-muted small fw-bold">Tipe</label>
                        <input type="text" name="new_items[${partIndex}][tipe]" class="form-control">
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label text-muted small fw-bold">Dimensi</label>
                        <div class="input-group">
                            <input type="text" name="new_items[${partIndex}][dimensi]" class="form-control">
                            <span class="input-group-text">mm</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label text-muted small fw-bold">Konfigurasi</label>
                        <input type="text" name="new_items[${partIndex}][konfigurasi]" class="form-control">
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label text-muted small fw-bold">Beban</label>
                        <div class="input-group">
                            <input type="text" name="new_items[${partIndex}][load]" class="form-control">
                            <span class="input-group-text">kg</span>
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('items-container').appendChild(div);
            partIndex++;
        }
        
    </script>
</body>
</html>