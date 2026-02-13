<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Spesifikasi - {{ $product->nama_barang }}</title>
    <title>E-Catalogue UT</title>
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
            opacity: 0.08; /* Ubah ini untuk mengatur ketipisan */
            z-index: -1;
        }
        .navbar-custom { background-color: #1a459c; padding: 15px 25px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin-bottom: 30px; }
        .btn-back { color: white; font-size: 24px; text-decoration: none; }
        .header-title { color: white; font-weight: 600; font-size: 18px; text-transform: uppercase; }
        
        .section-card { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 15px rgba(0,0,0,0.03); margin: 0 auto 25px auto; border: 1px solid #f0f0f0; max-width: 800px; }
        .section-label { font-size: 16px; font-weight: 600; color: #1a459c; margin-bottom: 15px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; }
        
        .form-control { border-radius: 10px; border: 1px solid #ddd; padding: 10px 15px; font-size: 14px; }

        /* Style Foto Lama */
        .existing-img-wrapper { position: relative; width: 100px; height: 100px; border-radius: 10px; overflow: hidden; border: 2px solid #eee; background: white; }
        .existing-img-wrapper img { width: 100%; height: 100%; object-fit: cover; }
        .delete-overlay { position: absolute; inset: 0; background: rgba(220,53,69,0.9); color: white; display: flex; align-items: center; justify-content: center; font-size: 12px; opacity: 0; transition: 0.2s; cursor: pointer; }
        
        /* Checkbox hidden tapi men-trigger overlay */
        .del-check:checked + img + .delete-overlay { opacity: 1; }
        .del-check { position: absolute; top: 5px; right: 5px; z-index: 10; accent-color: red; width: 16px; height: 16px; cursor: pointer; }

        .btn-action-group { display: flex; justify-content: flex-end; gap: 10px; margin-top: 30px; }
        .btn-custom { border: none; border-radius: 50px; padding: 12px 30px; font-weight: 600; font-size: 14px; }
        .btn-batal { background-color: #dc1f26; color: white; text-decoration: none; display: inline-flex; align-items: center; }
        .btn-simpan { background-color: #1a459c; color: white; }
    </style>
</head>
<body>

    <div class="navbar-custom d-flex align-items-center">
        <a href="/detail/{{ $product->id }}" class="btn-back me-3"><i class="fas fa-arrow-left"></i></a>
        <div class="header-title">Edit Spesifikasi</div>
    </div>

    <div class="container">
        <form action="/update-spec/{{ $product->id }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="section-card">
                <div class="section-label"><i class="fas fa-info-circle me-2"></i> Informasi Produk</div>
                <div class="row g-3">
                    <div class="col-md-6"><label class="small fw-bold text-muted">Nama Customer</label><input type="text" name="nama_customer" class="form-control" value="{{ $product->nama_customer }}"></div>
                    <div class="col-md-6"><label class="small fw-bold text-muted">Nama Barang</label><input type="text" name="nama_barang" class="form-control" value="{{ $product->nama_barang }}"></div>
                    <div class="col-md-6"><label class="small fw-bold text-muted">Material</label><input type="text" name="jenis_material" class="form-control" value="{{ $product->jenis_material }}"></div>
                    <div class="col-md-6"><label class="small fw-bold text-muted">Finishing</label><input type="text" name="finishing" class="form-control" value="{{ $product->finishing }}"></div>
                    <div class="col-md-6"><label class="small fw-bold text-muted">Type</label><input type="text" name="tipe" class="form-control" value="{{ $product->tipe }}"></div>
                </div>
            </div>

            <div class="section-card mt-4">
                <div class="section-label">
                    <i class="fas fa-ruler-combined me-2"></i> Dimensi Produk (Edit Ukuran)
                </div>

                <div class="p-4">
                    <table class="table table-borderless align-middle" id="dimensiTable">
                        <thead>
                            <tr class="border-bottom">
                                <th style="width: 23%"><label class="small fw-bold text-muted">Panjang (mm)</label></th>
                                <th style="width: 23%"><label class="small fw-bold text-muted">Lebar (mm)</label></th>
                                <th style="width: 23%"><label class="small fw-bold text-muted">Tinggi (mm)</label></th>
                                <th style="width: 23%"><label class="small fw-bold text-muted">Kedalaman (mm)</label></th>
                                <th style="width: 8%" class="text-center"><label class="small fw-bold text-muted">Hapus</label></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($dimensions->isEmpty())
                                <tr>
                                    <td class="p-2"><input type="number" name="dim_panjang[]" class="form-control" placeholder="0"></td>
                                    <td class="p-2"><input type="number" name="dim_lebar[]" class="form-control" placeholder="0"></td>
                                    <td class="p-2"><input type="number" name="dim_tinggi[]" class="form-control" placeholder="0"></td>
                                    <td class="p-2"><input type="number" name="dim_kedalaman[]" class="form-control" placeholder="0"></td>
                                    <td class="text-center p-2">
                                        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill mt-2" onclick="removeRow(this)">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @else
                                @foreach($dimensions as $dim)
                                <tr>
                                    <td class="p-2"><input type="number" name="dim_panjang[]" class="form-control" value="{{ $dim->panjang }}"></td>
                                    <td class="p-2"><input type="number" name="dim_lebar[]" class="form-control" value="{{ $dim->lebar }}"></td>
                                    <td class="p-2"><input type="number" name="dim_tinggi[]" class="form-control" value="{{ $dim->tinggi }}"></td>
                                    <td class="p-2"><input type="number" name="dim_kedalaman[]" class="form-control" value="{{ $dim->kedalaman }}"></td>
                                    <td class="text-center p-2">
                                        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill mt-2" onclick="removeRow(this)">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill mt-2" onclick="addDimensiRow()">
                        <i class="fas fa-plus me-1"></i> Tambah Variasi Ukuran
                    </button>
                </div>
            </div>

            <div class="section-card">
                <div class="section-label"><i class="fas fa-images me-2"></i> Foto Gallery</div>
                
                <p class="small text-muted fw-bold">Foto Saat Ini (Centang untuk menghapus):</p>
                <div class="d-flex gap-2 flex-wrap mb-4">
                    @foreach($gallery as $img)
                    <div class="existing-img-wrapper">
                        <input type="checkbox" name="delete_gallery_ids[]" value="{{ $img->id }}" class="del-check" title="Hapus">
                        <img src="{{ asset('storage/'.$img->image_path) }}">
                        <div class="delete-overlay"><i class="fas fa-trash"></i></div>
                    </div>
                    @endforeach
                </div>

                <div class="p-3 bg-light rounded border">
                    <label class="small fw-bold text-primary mb-2">Upload Foto Baru:</label>
                    
                    <div id="gallery-container">
                        <div class="d-flex align-items-center gap-2 mb-2 position-relative">
                            <input type="file" name="foto_barang_baru[]" class="form-control" accept="image/*" onchange="previewImage(this)">
                            <div style="width:50px; height:50px; background:#eee; border-radius:8px; overflow:hidden; display:none;"><img src="" style="width:100%; height:100%; object-fit:cover;"></div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill mt-2" onclick="addGalleryInput()">
                        <i class="fas fa-plus me-1"></i> Tambah Foto Lain
                    </button>
                </div>
            </div>

            <div class="container" style="max-width: 800px;">
                <div class="btn-action-group">
                    <a href="/detail/{{ $product->id }}" class="btn-custom btn-batal">Batal</a>
                    <button type="submit" class="btn-custom btn-simpan">Simpan Data</button>
                </div>
            </div>

        </form>
    </div>

    <script>
        // 1. Fungsi Tambah Input Gallery
        function addGalleryInput() {
            const div = document.createElement('div');
            div.className = 'd-flex align-items-center gap-2 mb-2 position-relative';
            div.innerHTML = `
                <input type="file" name="foto_barang_baru[]" class="form-control" accept="image/*" onchange="previewImage(this)">
                <div style="width:50px; height:50px; background:#eee; border-radius:8px; overflow:hidden; display:none;"><img src="" style="width:100%; height:100%; object-fit:cover;"></div>
                <button type="button" class="btn btn-danger btn-sm rounded-circle" style="width:30px; height:30px; padding:0;" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            `;
            document.getElementById('gallery-container').appendChild(div);
        }

        // 2. Preview
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

        function addDimensiRow() {
                    let tbody = document.getElementById('dimensiTable').getElementsByTagName('tbody')[0];
                    let newRow = tbody.insertRow();
                    
                    newRow.innerHTML = `
                        <td class="p-2"><input type="number" name="dim_panjang[]" class="form-control" placeholder="0"></td>
                        <td class="p-2"><input type="number" name="dim_lebar[]" class="form-control" placeholder="0"></td>
                        <td class="p-2"><input type="number" name="dim_tinggi[]" class="form-control" placeholder="0"></td>
                        <td class="p-2"><input type="number" name="dim_kedalaman[]" class="form-control" placeholder="0"></td>
                        <td class="text-center p-2">
                            <button type="button" class="btn btn-outline-danger btn-sm rounded-pill mt-2" onclick="removeRow(this)">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    `;
                }

                function removeRow(btn) {
                    let row = btn.parentNode.parentNode;
                    let tbody = row.parentNode;
                    if (tbody.rows.length > 1) {
                        tbody.removeChild(row);
                    } else {
                        // Jika tinggal 1 baris, kosongkan saja nilainya jangan dihapus barisnya
                        let inputs = row.getElementsByTagName('input');
                        for(let i=0; i<inputs.length; i++) inputs[i].value = '';
                    }
                }
    </script>
</body>
</html>