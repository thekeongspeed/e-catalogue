<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // --- AUTHENTICATION ---
    public function loginForm() {
        return view('login');
    }

    public function loginProcess(Request $request) {
        if ($request->password === 'admin123') { 
            session(['is_admin' => true]);
            return redirect('/manage'); // Setelah login, balik ke dashboard utama
        }
        return back()->with('error', 'Password Salah!');
    }

    public function logout() {
        session()->forget('is_admin');
        return redirect('/');
    }

   // --- DASHBOARD: MENU PILIHAN TOKO ---
    public function index() {
        // Ambil nama customer yang unik saja (DISTINCT)
        // Agar Indomaret tidak muncul 10 kali jika ada 10 barang
        $customers = DB::table('products')
                    ->select('nama_customer')
                    ->distinct()
                    ->orderBy('nama_customer', 'asc')
                    ->get();
        
        return view('dashboard', compact('customers'));
    }

    // --- PROSES INPUT (HANYA ADMIN) ---
 public function store(Request $request) {
        if (!session('is_admin')) return redirect('/login');

        // 1. Handle Upload Foto Utama (Multiple)
        $thumbnailPath = null;
        
        // Cek jika ada file yang diupload
        if ($request->hasFile('foto_barang')) {
            // Ambil file pertama untuk jadi Thumbnail Dashboard
            $thumbnailPath = $request->file('foto_barang')[0]->store('uploads', 'public');
        }

        // 2. Simpan Data Produk
        $productId = DB::table('products')->insertGetId([
            'nama_customer' => $request->nama_customer,
            'nama_barang' => $request->nama_barang,
            'nama_item' => 'Multi Item',
            'panjang' => $request->panjang,
            'lebar' => $request->lebar,
            'tinggi' => $request->tinggi,
            'kedalaman' => $request->kedalaman,
            'jenis_material' => $request->jenis_material,
            'finishing' => $request->finishing,
            'foto_barang' => $thumbnailPath, // Simpan 1 foto untuk thumbnail
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Simpan SEMUA Foto ke Tabel Galeri (ProductImages)
        if ($request->hasFile('foto_barang')) {
            foreach($request->file('foto_barang') as $photo) {
                $path = $photo->store('uploads', 'public');
                DB::table('product_images')->insert([
                    'product_id' => $productId,
                    'image_path' => $path,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 4. Simpan Item Parts (Anak)
        if ($request->has('items')) {
            foreach ($request->items as $key => $itemData) {
                // Skip jika nama item kosong
                if (empty($itemData['name'])) continue;

                $fotoPath = null;
                // Handle Upload Foto Part
                if (isset($request->file('items')[$key]['image'])) {
                    $fotoPath = $request->file('items')[$key]['image']->store('uploads', 'public');
                }

                DB::table('product_items')->insert([
                    'product_id' => $productId,
                    'nama_item' => $itemData['name'],
                    'foto_item' => $fotoPath,
                    
                    // KOLOM BARU YANG DITAMBAHKAN
                    'tipe' => $itemData['tipe'] ?? null,
                    'dimensi_part' => $itemData['dimensi'] ?? null,
                    'konfigurasi' => $itemData['konfigurasi'] ?? null,
                    'load_capacity' => $itemData['load'] ?? null,
                    
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

      // 5. Simpan Project Reference (DENGAN TEMPAT)
        if ($request->hasFile('project_images')) {
            // Kita loop berdasarkan file gambar
            foreach($request->file('project_images') as $key => $img) {
                $path = $img->store('uploads', 'public');
                
                // Ambil teks tempat berdasarkan index ($key) yang sama dengan gambar
                $placeText = $request->project_places[$key] ?? null; 

                DB::table('project_references')->insert([
                    'product_id' => $productId,
                    'image_path' => $path,
                    'place' => $placeText, // Simpan Tempat
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return back()->with('success', 'Data Katalog berhasil disimpan!');
    }

   public function customerPage(Request $request, $name) {
        // 1. Mulai Query Dasar (Filter Customer dulu)
        $query = DB::table('products')->where('nama_customer', $name);

        // 2. Cek apakah ada pencarian?
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            // Filter nama barang yang MIRIP dengan keyword
            $query->where('nama_barang', 'LIKE', '%' . $keyword . '%');
        }

        // 3. Eksekusi Query
        $products = $query->get();

        // 4. Ambil Foto Utama untuk setiap produk (Thumbnail)
        foreach($products as $p) {
            $p->thumbnail = DB::table('product_images')
                            ->where('product_id', $p->id)
                            ->value('image_path');
        }

        return view('customer_page', compact('products', 'name'));
    }
    
    // --- HAPUS DATA (HANYA ADMIN) ---
    public function destroy($id) {
        if (!session('is_admin')) return redirect('/login');
        
        DB::table('products')->where('id', $id)->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }

    // --- CETAK PDF ---

    // GANTI NAMA FUNGSI DARI 'print' MENJADI 'printProduct'
    public function printProduct(Request $request) {
        $id = $request->query('id'); // Ambil ID dari link ?id=...
        
        $product = DB::table('products')->where('id', $id)->first();

        if (!$product) {
            // Debugging: Jika produk tidak ketemu, akan muncul tulisan ini
            return "Error: Produk dengan ID $id tidak ditemukan di database.";
        }

        // Ambil Data Relasi
        $gallery = DB::table('product_images')->where('product_id', $product->id)->get();
        $items = DB::table('product_items')->where('product_id', $product->id)->get();
        $projects = DB::table('project_references')->where('product_id', $product->id)->get();

        // Load View PDF Satuan (print_product.blade.php)
        $pdf = \PDF::loadView('print_product', compact('product', 'gallery', 'items', 'projects'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->stream('Produk-' . $product->nama_barang . '.pdf');
    }


    public function printCustomer(Request $request) {
        $name = $request->query('name'); // Ambil nama customer dari URL
        
        // 1. Ambil SEMUA produk milik customer ini
        $products = DB::table('products')->where('nama_customer', $name)->get();

        if ($products->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada produk untuk customer ini.');
        }

        // 2. Siapkan array untuk menampung data lengkap setiap produk
        $data = [];

        foreach($products as $p) {
            $data[] = [
                'product' => $p,
                'gallery' => DB::table('product_images')->where('product_id', $p->id)->get(),
                'items'   => DB::table('product_items')->where('product_id', $p->id)->get(),
                'projects'=> DB::table('project_references')->where('product_id', $p->id)->get(),
            ];
        }

        // 3. Load View PDF Khusus Katalog (print_catalog)
        // Kita kirim variabel $data yang berisi list semua produk
        $pdf = \PDF::loadView('print_catalog', compact('data', 'name'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->stream('Katalog-Lengkap-' . $name . '.pdf');
    }

    // --- HALAMAN KHUSUS CUSTOMER ---
    public function showCustomer($name) {
        // Ambil data hanya milik customer yang diklik
        $products = DB::table('products')
                    ->where('nama_customer', $name)
                    ->orderBy('id', 'desc')
                    ->get();

        // Kita pakai view baru bernama 'customer_page'
        return view('customer_page', compact('products', 'name'));
    }

    public function manageData() {
    if (!session('is_admin')) return redirect('/login');

    // Gunakan view input lama, atau copy view input.blade.php yang lama ke sini
    $products = DB::table('products')->orderBy('id', 'desc')->get();
    return view('input', compact('products')); // Pastikan file input.blade.php masih ada
}

// --- HALAMAN DETAIL PRODUK (SINGLE PAGE) ---
   public function detailProduct($id) {
        $product = DB::table('products')->where('id', $id)->first();
        if (!$product) return redirect('/')->with('error', 'Produk tidak ditemukan');

        // Ambil Item Parts
        $items = DB::table('product_items')->where('product_id', $id)->get();

        // TAMBAHAN: Ambil Galeri Foto untuk Slideshow
        $gallery = DB::table('product_images')->where('product_id', $id)->get();
        $projects = DB::table('project_references')->where('product_id', $id)->get();

        return view('detail_product', compact('product', 'items', 'gallery', 'projects'));
    }

    // --- MENAMPILKAN FORM EDIT ---
    public function editForm($id) {
        if (!session('is_admin')) return redirect('/login');

        // 1. Ambil Data Produk Utama
        $product = DB::table('products')->where('id', $id)->first();
        if (!$product) return redirect('/')->with('error', 'Produk tidak ditemukan');

        // 2. Ambil Data Galeri Foto
        $gallery = DB::table('product_images')->where('product_id', $id)->get();

        // 3. Ambil Data Item Parts
        $items = DB::table('product_items')->where('product_id', $id)->get();
        $projects = DB::table('project_references')->where('product_id', $id)->get();
        // Kirim semua data ke view baru 'edit.blade.php'
        return view('edit', compact('product', 'gallery', 'items', 'projects'));
    }


    // --- PROSES UPDATE DATA (LOGIKA KOMPLEKS) ---
    public function updateData(Request $request, $id) {
        if (!session('is_admin')) return redirect('/login');

        // --- A. UPDATE DATA UTAMA PRODUK ---
        DB::table('products')->where('id', $id)->update([
            'nama_customer' => $request->nama_customer,
            'nama_barang' => $request->nama_barang,
            'panjang' => $request->panjang,
            'lebar' => $request->lebar,
            'tinggi' => $request->tinggi,
            'kedalaman' => $request->kedalaman,
            'jenis_material' => $request->jenis_material,
            'finishing' => $request->finishing,
            'updated_at' => now(),
        ]);

        // --- B. MANAGEMENT GALERI FOTO ---
        
        // 1. Hapus Foto Galeri yang ditandai untuk dihapus
        if ($request->has('delete_gallery_ids')) {
            foreach($request->delete_gallery_ids as $imgId) {
                // Ambil path gambar dulu untuk dihapus dari storage
                $img = DB::table('product_images')->where('id', $imgId)->first();
                if($img) {
                    // Hapus file dari folder storage/app/public/uploads
                    Storage::disk('public')->delete($img->image_path);
                    // Hapus record dari database
                    DB::table('product_images')->where('id', $imgId)->delete();
                }
            }
        }

        // 2. Tambah Foto Galeri Baru (jika ada upload baru)
        if ($request->hasFile('foto_barang_baru')) {
            foreach($request->file('foto_barang_baru') as $photo) {
                $path = $photo->store('uploads', 'public');
                DB::table('product_images')->insert([
                    'product_id' => $id,
                    'image_path' => $path,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }


        // --- C. MANAGEMENT ITEM PARTS (SANGAT KOMPLEKS) ---

        // 1. Ambil semua ID item yang ada di database saat ini untuk produk ini
        $existingItemIds = DB::table('product_items')->where('product_id', $id)->pluck('id')->toArray();
        
        // 2. Ambil semua ID item yang disubmit dari form (yang tidak null)
        $submittedItemIds = [];
        if($request->has('items')) {
            foreach($request->items as $itemData) {
                if(isset($itemData['id'])) {
                    $submittedItemIds[] = $itemData['id'];
                }
            }
        }

        // 3. Cari ID mana yang ada di database TAPI tidak disubmit di form (artinya dihapus user)
        $itemsToDelete = array_diff($existingItemIds, $submittedItemIds);
        
        // 4. Hapus Item yang ditandai
        if(!empty($itemsToDelete)) {
             // Optional: Hapus foto partnya dulu dari storage jika perlu
             DB::table('product_items')->whereIn('id', $itemsToDelete)->delete();
        }

        // 5. Loop data items yang disubmit untuk Update atau Insert
        if ($request->has('items')) {
            foreach ($request->items as $key => $itemData) {
                if (empty($itemData['name'])) continue; // Skip jika nama kosong

                $dataToSave = [
                    'nama_item' => $itemData['name'],
                    'tipe' => $itemData['tipe'] ?? null,
                    'dimensi_part' => $itemData['dimensi'] ?? null,
                    'konfigurasi' => $itemData['konfigurasi'] ?? null,
                    'load_capacity' => $itemData['load'] ?? null,
                    'updated_at' => now(),
                ];

                // Cek jika ada upload foto baru untuk part ini
                if (isset($request->file('items')[$key]['image'])) {
                    $fotoPath = $request->file('items')[$key]['image']->store('uploads', 'public');
                    $dataToSave['foto_item'] = $fotoPath;
                }

                if (isset($itemData['id'])) {
                    // --- UPDATE ITEM YANG SUDAH ADA ---
                    DB::table('product_items')->where('id', $itemData['id'])->update($dataToSave);
                } else {
                    // --- INSERT ITEM BARU (yang ditambahkan lewat JS) ---
                    $dataToSave['product_id'] = $id;
                    $dataToSave['created_at'] = now();
                    DB::table('product_items')->insert($dataToSave);
                }
            }
        }

        // 1. Hapus Foto Project yang ditandai
        if ($request->has('delete_project_ids')) {
            foreach($request->delete_project_ids as $pId) {
                $img = DB::table('project_references')->where('id', $pId)->first();
                if($img) {
                    Storage::disk('public')->delete($img->image_path);
                    DB::table('project_references')->where('id', $pId)->delete();
                }
            }
        }

        // 2. Tambah Foto Project Baru
        if ($request->hasFile('project_images_baru')) {
            foreach($request->file('project_images_baru') as $photo) {
                $path = $photo->store('uploads', 'public');
                DB::table('project_references')->insert([
                    'product_id' => $id,
                    'image_path' => $path,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        

        // Redirect kembali ke halaman detail produk
        return redirect('/detail/' . $id)->with('success', 'Data produk berhasil diperbarui!');
    }


    // ==========================================
    // 1. FITUR EDIT SPESIFIKASI (General, Dimensi, Gallery)
    // ==========================================
    public function editSpec($id) {
        if (!session('is_admin')) return redirect('/login');
        $product = DB::table('products')->where('id', $id)->first();
        $gallery = DB::table('product_images')->where('product_id', $id)->get();
        return view('edits.spec', compact('product', 'gallery'));
    }

    public function updateSpec(Request $request, $id) {
        // A. Update Info Utama
        DB::table('products')->where('id', $id)->update([
            'nama_customer' => $request->nama_customer,
            'nama_barang' => $request->nama_barang,
            'panjang' => $request->panjang,
            'lebar' => $request->lebar,
            'tinggi' => $request->tinggi,
            'kedalaman' => $request->kedalaman,
            'jenis_material' => $request->jenis_material,
            'finishing' => $request->finishing,
            'updated_at' => now(),
        ]);

        // B. Update Gallery (Hapus & Tambah)
        if ($request->has('delete_gallery_ids')) {
            foreach($request->delete_gallery_ids as $imgId) {
                $img = DB::table('product_images')->where('id', $imgId)->first();
                if($img) {
                    Storage::disk('public')->delete($img->image_path);
                    DB::table('product_images')->where('id', $imgId)->delete();
                }
            }
        }
        if ($request->hasFile('foto_barang_baru')) {
            foreach($request->file('foto_barang_baru') as $photo) {
                $path = $photo->store('uploads', 'public');
                DB::table('product_images')->insert([
                    'product_id' => $id, 'image_path' => $path, 'created_at' => now(), 'updated_at' => now()
                ]);
            }
        }

        return redirect('/detail/' . $id . '#spec')->with('success', 'Spesifikasi berhasil diupdate!');
    }

    // ==========================================
    // 2. FITUR EDIT PARTS (Komponen)
    // ==========================================
    public function editParts($id) {
        if (!session('is_admin')) return redirect('/login');
        $product = DB::table('products')->where('id', $id)->first();
        $items = DB::table('product_items')->where('product_id', $id)->get();
        return view('edits.parts', compact('product', 'items'));
    }

    public function updateParts(Request $request, $id) {
        // Hapus Part
        if ($request->has('delete_part_ids')) {
            DB::table('product_items')->whereIn('id', $request->delete_part_ids)->delete();
        }

        // Update/Insert Part
        if ($request->has('items')) {
            foreach ($request->items as $itemData) {
                if (empty($itemData['name'])) continue;

                $dataToSave = [
                    'nama_item' => $itemData['name'],
                    'tipe' => $itemData['tipe'] ?? null,
                    'dimensi_part' => $itemData['dimensi'] ?? null,
                    'konfigurasi' => $itemData['konfigurasi'] ?? null,
                    'load_capacity' => $itemData['load'] ?? null,
                    'updated_at' => now(),
                ];

                if (isset($itemData['image'])) {
                    $dataToSave['foto_item'] = $itemData['image']->store('uploads', 'public');
                }

                if (isset($itemData['id'])) {
                    DB::table('product_items')->where('id', $itemData['id'])->update($dataToSave);
                } else {
                    $dataToSave['product_id'] = $id;
                    $dataToSave['created_at'] = now();
                    DB::table('product_items')->insert($dataToSave);
                }
            }
        }
        return redirect('/detail/' . $id . '#parts')->with('success', 'Parts berhasil diupdate!');
    }

    // ==========================================
    // 3. FITUR EDIT PROJECT REFERENCE
    // ==========================================
    public function editProject($id) {
        if (!session('is_admin')) return redirect('/login');
        $product = DB::table('products')->where('id', $id)->first();
        $projects = DB::table('project_references')->where('product_id', $id)->get();
        return view('edits.project', compact('product', 'projects'));
    }

    public function updateProject(Request $request, $id) {
        // 1. Hapus Foto (Logic Lama)
        if ($request->has('delete_project_ids')) {
            foreach($request->delete_project_ids as $pId) {
                $img = DB::table('project_references')->where('id', $pId)->first();
                if($img) {
                    Storage::disk('public')->delete($img->image_path);
                    DB::table('project_references')->where('id', $pId)->delete();
                }
            }
        }

        // 2. Update Teks Tempat pada Foto Lama (BARU)
        if ($request->has('existing_places')) {
            foreach($request->existing_places as $pId => $text) {
                DB::table('project_references')->where('id', $pId)->update([
                    'place' => $text,
                    'updated_at' => now()
                ]);
            }
        }

        // 3. Tambah Foto Project Baru (DENGAN TEMPAT)
        if ($request->hasFile('project_images_baru')) {
            foreach($request->file('project_images_baru') as $key => $photo) {
                $path = $photo->store('uploads', 'public');
                
                // Ambil teks tempat baru
                $placeText = $request->project_places_baru[$key] ?? null;

                DB::table('project_references')->insert([
                    'product_id' => $id, 
                    'image_path' => $path, 
                    'place' => $placeText, // Simpan Tempat
                    'created_at' => now(), 
                    'updated_at' => now()
                ]);
            }
        }

        return redirect('/detail/' . $id . '#project')->with('success', 'Project Reference berhasil diupdate!');
    }
}