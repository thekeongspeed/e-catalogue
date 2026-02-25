<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Data Customer</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* --- COPY STYLE DARI HALAMAN INPUT BARANG --- */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            min-height: 100vh;
            padding-bottom: 50px;
            position: relative;
        }

        /* Watermark Background */
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

        /* Navbar Style */
        .navbar-custom {
            background-color: #1a459c; padding: 15px 25px;
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin-bottom: 30px;
        }
        .btn-home { color: white; font-size: 24px; text-decoration: none; }
        .page-header-title { color: white; font-size: 18px; font-weight: 500; }

        /* Card Style */
        .section-card {
            background: white; border-radius: 15px; padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.03); margin-bottom: 25px; border: 1px solid #f0f0f0;
            height: 100%; /* Agar tinggi kartu sama */
        }

        /* Input Styles */
        .form-label-custom {
            font-size: 12px; font-weight: 600; text-transform: uppercase;
            letter-spacing: 0.5px; color: #6c757d; margin-bottom: 5px; display: block;
        }
        .input-group-text {
            background-color: #f8f9fa; border: 1px solid #dee2e6; border-right: none; color: #1a459c;
        }
        .form-control {
            border: 1px solid #dee2e6; border-left: none; padding: 10px 15px; font-size: 14px; transition: all 0.3s;
        }
        .input-group:focus-within .input-group-text { border-color: #1a459c; background-color: #eef2ff; }
        .input-group:focus-within .form-control { border-color: #1a459c; box-shadow: 0 0 0 3px rgba(26, 69, 156, 0.1); }

        /* Modern Header inside Card */
        .section-header-modern {
            display: flex; align-items: center; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px dashed #e0e0e0;
        }
        .section-title { font-size: 16px; font-weight: 700; color: #333; }

        /* Table Styling */
        .table-custom th {
            font-size: 13px; text-transform: uppercase; color: #6c757d; font-weight: 600; border-bottom: 2px solid #f0f0f0;
        }
        .table-custom td {
            vertical-align: middle; padding: 15px 10px;
        }
        .customer-logo-thumb {
            width: 50px; height: 50px; object-fit: contain; border-radius: 8px; border: 1px solid #eee; padding: 2px;
        }
    </style>
</head>
<body>

    <div class="navbar-custom">
        <div class="d-flex align-items-center gap-3">
            <a href="/manage" class="btn-home"><i class="fas fa-arrow-left"></i></a>
            <span class="page-header-title">Master Data Customer</span>
        </div>
        <div class="text-white small opacity-75">Kelola Nama & Logo</div>
    </div>

    <div class="container" style="max-width: 1000px;">
        
        @if(session('success')) 
            <div class="alert alert-success rounded-3 shadow-sm border-0 mb-4"><i class="fas fa-check-circle me-2"></i> {{ session('success') }}</div> 
        @endif

        <div class="row g-4">
            <div class="col-md-4">
                <div class="section-card">
                    <div class="section-header-modern">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div class="section-title">Tambah Baru</div>
                    </div>

                    <form action="/customers/store" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label-custom">Nama Customer</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                <input type="text" name="name" class="form-control" placeholder="Contoh: Alfamart" required autocomplete="off">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-custom">Logo Perusahaan</label>
                            
                            <div class="text-center mb-3 p-3 bg-light rounded border border-dashed" style="min-height: 100px; display: flex; align-items: center; justify-content: center;">
                                <img id="logoPreview" src="" style="max-width: 100px; max-height: 80px; display: none;">
                                <span id="logoPlaceholder" class="text-muted small"><i class="fas fa-image fa-2x mb-2 d-block"></i>Preview Logo</span>
                            </div>

                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-upload"></i></span>
                                <input type="file" name="logo" class="form-control" accept="image/*" onchange="previewLogo(this)">
                            </div>
                            <div class="form-text small text-muted mt-2">* Format: PNG/JPG (Transparan lebih baik)</div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 rounded-pill py-2">
                            <i class="fas fa-save me-2"></i> Simpan Customer
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-md-8">
                <div class="section-card">
                    <div class="section-header-modern">
                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                            <i class="fas fa-list"></i>
                        </div>
                        <div class="section-title">Daftar Customer Tersedia</div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-custom table-hover">
                            <thead>
                                <tr>
                                    <th width="15%" class="text-center">Logo</th>
                                    <th>Nama Customer</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $c)
                                <tr>
                                    <td class="text-center">
                                        @if($c->logo_path)
                                            <img src="{{ asset('storage/' . $c->logo_path) }}" class="customer-logo-thumb">
                                        @else
                                            <div class="customer-logo-thumb d-flex align-items-center justify-content-center bg-light text-muted">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $c->name }}</div>
                                        <div class="small text-muted">Ditambahkan: {{ \Carbon\Carbon::parse($c->created_at)->format('d M Y') }}</div>
                                    </td>
                                    <td class="text-center">
                                        <a href="/customers/delete/{{ $c->id }}" 
                                           class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" 
                                           onclick="return confirm('Hapus customer ini? Logo juga akan terhapus.')"
                                           title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">
                                        <i class="fas fa-folder-open fa-3x mb-3 text-light"></i>
                                        <p>Belum ada data customer.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewLogo(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('logoPreview').src = e.target.result;
                    document.getElementById('logoPreview').style.display = 'block';
                    document.getElementById('logoPlaceholder').style.display = 'none';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

</body>
</html>