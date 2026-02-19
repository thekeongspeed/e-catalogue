<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project - {{ $product->nama_barang }}</title>
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
        .navbar-custom { background-color: #1a459c; padding: 15px 25px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin-bottom: 30px; }
        .btn-back { color: white; font-size: 24px; text-decoration: none; }
        .header-title { color: white; font-weight: 600; font-size: 18px; text-transform: uppercase; }
        
        .section-card { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 15px rgba(0,0,0,0.03); margin: 0 auto 25px auto; border: 1px solid #f0f0f0; max-width: 800px; }
        .section-label { font-size: 16px; font-weight: 600; color: #1a459c; margin-bottom: 15px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; }
        
        .form-control { border-radius: 10px; border: 1px solid #ddd; padding: 10px 15px; font-size: 14px; }
        
        /* Style Foto Lama */
        .existing-img-wrapper { position: relative; width: 100px; height: 80px; border-radius: 8px; overflow: hidden; border: 1px solid #eee; flex-shrink: 0; }
        .existing-img-wrapper img { width: 100%; height: 100%; object-fit: cover; }
        
        /* Checkbox Hapus Custom */
        .delete-overlay {
            position: absolute; inset: 0; background: rgba(220, 53, 69, 0.9);
            color: white; display: flex; align-items: center; justify-content: center;
            font-size: 11px; opacity: 0; transition: 0.2s; pointer-events: none;
        }
        .check-delete:checked + img + .delete-overlay { opacity: 1; }
        .check-delete { position: absolute; top: 5px; right: 5px; z-index: 10; cursor: pointer; accent-color: #dc3545; width: 16px; height: 16px; }

        .btn-action-group { display: flex; justify-content: flex-end; gap: 10px; margin-top: 30px; }
        .btn-custom { border: none; border-radius: 50px; padding: 12px 30px; font-weight: 600; font-size: 14px; }
        .btn-batal { background-color: #dc1f26; color: white; text-decoration: none; display: inline-flex; align-items: center; }
        .btn-simpan { background-color: #1e9c1a; color: white; }
    </style>
</head>
<body>

    <div class="navbar-custom d-flex align-items-center">
        <a href="/detail/{{ $product->id }}" class="btn-back me-3"><i class="fas fa-arrow-left"></i></a>
        <div class="header-title">Edit Project Reference</div>
    </div>

    <div class="container">
        <form action="/update-project/{{ $product->id }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="section-card">
                <div class="section-label"><i class="fas fa-hard-hat me-2"></i> Kelola Foto Project</div>
                
                @if(!$projects->isEmpty())
                    <p class="small fw-bold text-muted mb-3">Project yang Sudah Ada (Bisa Edit Teks / Hapus):</p>
                    <div class="row g-3 mb-4">
                        @foreach($projects as $p)
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-3 p-2 border rounded bg-light h-100">
                                <div class="existing-img-wrapper">
                                    <input type="checkbox" name="delete_project_ids[]" value="{{ $p->id }}" class="check-delete" title="Centang untuk menghapus">
                                    <img src="{{ asset('storage/'.$p->image_path) }}">
                                    <div class="delete-overlay"><i class="fas fa-trash me-1"></i> Hapus</div>
                                </div>
                                
                                <div class="flex-grow-1">
                                    <label class="small text-muted mb-1 fw-bold">Lokasi / Tempat:</label>
                                    <input type="text" name="existing_places[{{ $p->id }}]" class="form-control form-control-sm bg-white" value="{{ $p->place }}" placeholder="Nama Lokasi...">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-light border text-center text-muted mb-4">
                        Belum ada data project.
                    </div>
                @endif

                <hr class="my-4 text-muted opacity-25">

                <div class="p-3 bg-white rounded border shadow-sm">
                    <label class="form-label fw-bold text-primary mb-2">Tambah Project Baru:</label>
                    
                    <div id="project-container">
                        </div>

                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill mt-2" onclick="addProjectInput()">
                        <i class="fas fa-plus me-1"></i> Tambah Baris Baru
                    </button>
                </div>
            </div>

            <div class="container" style="max-width: 800px;">
                <div class="btn-action-group">
                    <a href="/detail/{{ $product->id }}" class="btn-custom btn-batal">Batal</a>
                    <button type="submit" class="btn-custom btn-simpan">Simpan Perubahan</button>
                </div>
            </div>

        </form>
    </div>

    <script>
        // Fungsi Tambah Input Project (Dua Kolom: Teks & File)
        function addProjectInput() {
            const div = document.createElement('div');
            div.className = 'row g-2 mb-2 align-items-center position-relative border-bottom pb-2'; 
            div.innerHTML = `
                <div class="col-5">
                    <input type="text" name="project_places_baru[]" class="form-control" placeholder="Nama Tempat / Lokasi">
                </div>
                <div class="col-6">
                    <input type="file" name="project_images_baru[]" class="form-control" accept="image/*" onchange="previewImage(this)">
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

        // Preview Function
        function previewImage(input) {
            const file = input.files[0];
            const row = input.closest('.row');
            const previewBox = row.querySelector('.col-12'); 
            
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