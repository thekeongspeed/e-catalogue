<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Divisi</title>

     <link rel="icon" href="{{ asset('/bg-watermark.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('/bg-watermark.png') }}" type="image/x-icon">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f9f9f9; }
        .navbar-custom {
            background-color: #1a459c; padding: 15px 25px;
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin-bottom: 30px;
        }
        .btn-home { color: white; font-size: 24px; text-decoration: none; }
        .btn-logout { background-color: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); padding: 8px 25px; border-radius: 50px; font-weight: 500; text-decoration: none; font-size: 14px; }
        .section-card { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 15px rgba(0,0,0,0.03); border: 1px solid #f0f0f0; }
    </style>
</head>
<body>
    <div class="navbar-custom">
        <a href="/" class="btn-home"><i class="fas fa-home"></i></a>
        <a href="/logout" class="btn-logout">Logout</a>
    </div>

    <div class="container py-4" style="max-width: 600px;">
        <h4 class="mb-4 fw-bold">Kelola Data Material Parts</h4>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Form Tambah Divisi --}}
        <div class="section-card mb-4">
            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-plus-circle me-2"></i>Tambah Data Material Baru</h6>
            <form action="/part-materials/store" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="name" class="form-control" placeholder="Nama Material..." required>
                    <button type="submit" class="btn btn-primary px-4">Simpan</button>
                </div>
            </form>
        </div>

        {{-- Daftar Divisi --}}
        <div class="section-card">
            <h6 class="fw-bold mb-3"><i class="fas fa-list me-2"></i>Daftar Data Material Parts</h6>
            @forelse($partMaterials as $div)
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <span>{{ $div->name }}</span>
                    <form action="/part-materials/{{ $div->id }}" method="POST" onsubmit="return confirm('Hapus data material ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-muted fst-italic">Belum ada data material.</p>
            @endforelse
        </div>
    </div>
</body>
</html>