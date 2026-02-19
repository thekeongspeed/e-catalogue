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
        // 1. Simpan Data Produk (Update: Tambah Color & Price)
        $productId = DB::table('products')->insertGetId([
            'nama_customer' => $request->nama_customer,
            'nama_barang'   => $request->nama_barang,
            'jenis_material'=> $request->jenis_material,
            'finishing'     => $request->finishing,
            'tipe'          => $request->tipe,
            
            // KOLOM BARU
            'color_available' => $request->color_available,
            'price'           => $request->price,
            
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        // 2. Simpan Foto (Logic Hybrid tetap dipakai)
        if ($request->hasFile('foto_barang')) {
            foreach($request->file('foto_barang') as $key => $photo) {
                $path = $photo->store('uploads', 'public');
                DB::table('product_images')->insert([
                    'product_id' => $productId, 'image_path' => $path, 'created_at' => now(), 'updated_at' => now(),
                ]);
                if ($key == 0) {
                    DB::table('products')->where('id', $productId)->update(['foto_barang' => $path]);
                }
            }
        }

        // 3. Simpan Dimensi (Update: Tambah Item Code)
        if ($request->has('dim_panjang')) {
            $panjang = $request->dim_panjang;
            $lebar   = $request->dim_lebar;
            $tinggi  = $request->dim_tinggi;
            $kedalam = $request->dim_kedalaman;
            
            // AMBIL ITEM CODE
            $codes   = $request->dim_item_code; 

            for ($i = 0; $i < count($panjang); $i++) {
                // Simpan jika salah satu data dimensi terisi
                if (!empty($panjang[$i]) || !empty($lebar[$i]) || !empty($tinggi[$i])) {
                    DB::table('product_dimensions')->insert([
                        'product_id' => $productId,
                        'item_code'  => $codes[$i] ?? null, // Simpan Item Code
                        'panjang'    => $panjang[$i],
                        'lebar'      => $lebar[$i],
                        'tinggi'     => $tinggi[$i],
                        'kedalaman'  => $kedalam[$i],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // 4. Simpan Parts (Update: Nama Jadi Optional)
        if ($request->items) {
            foreach ($request->items as $itemData) {
                // Hapus pengecekan 'empty name continue', biar bisa simpan walau nama kosong
                // Asalkan ada gambar atau tipe, kita simpan.
                
                // Cek minimal salah satu field terisi agar tidak nyampah record kosong
                if (empty($itemData['name']) && !isset($itemData['image']) && empty($itemData['tipe'])) {
                    continue; 
                }

                $dataPart = [
                    'product_id' => $productId,
                    'nama_item' => $itemData['name'] ?? null, // Boleh null
                    'tipe' => $itemData['tipe'] ?? null,
                    'dimensi_part' => $itemData['dimensi'] ?? null,
                    'konfigurasi' => $itemData['konfigurasi'] ?? null,
                    'load_capacity' => $itemData['load'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                if (isset($itemData['image'])) {
                    $dataPart['foto_item'] = $itemData['image']->store('uploads', 'public');
                }
                DB::table('product_items')->insert($dataPart);
            }
        }

        // 5. Simpan Project Reference (Tetap sama)
        if ($request->hasFile('project_images')) {
            foreach($request->file('project_images') as $key => $img) {
                $path = $img->store('uploads', 'public');
                $placeText = $request->project_places[$key] ?? null; 
                DB::table('project_references')->insert([
                    'product_id' => $productId, 'image_path' => $path, 'place' => $placeText, 'created_at' => now(), 'updated_at' => now(),
                ]);
            }
        }

        return redirect('/')->with('success', 'Data Katalog berhasil disimpan!');
    }


public function customerPage(Request $request, $name) {
        // 1. Siapkan Query Dasar
        $customerData = DB::table('customers')->where('name', $name)->first();
        $logoUrl = $customerData && $customerData->logo_path ? asset('storage/' . $customerData->logo_path) : null;
        $query = DB::table('products')->where('nama_customer', $name);

        // 2. Filter Search (Jika Ada)
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_barang', 'LIKE', '%' . $request->search . '%');
        }

        // 3. QUERY UTAMA (JURUS SUBQUERY)
        // Kita ambil semua kolom produk (*)
        // DAN kita paksa ambil 1 'image_path' dari tabel product_images sebagai kolom 'thumbnail'
        $products = $query
            ->select('products.*')
            ->addSelect(DB::raw('(SELECT image_path FROM product_images WHERE product_images.product_id = products.id LIMIT 1) as thumbnail'))
            ->orderBy('id', 'desc')
            ->get();

        return view('customer_page', compact('products', 'name', 'logoUrl'));
    }



    // --- FUNGSI HAPUS BARANG & GAMBAR ---
   public function destroyProduct($id) {
        
        // 1. PENTING: Ambil data produk DULU sebelum dihapus
        $product = DB::table('products')->where('id', $id)->first();

        // Validasi kecil: jika produk tidak ditemukan (mungkin sudah terhapus duluan)
        if (!$product) {
            return redirect()->back()->with('error', 'Data produk tidak ditemukan.');
        }

        // 2. Simpan nama customer ke variabel sementara
        // Kita butuh ini untuk redirect di baris paling bawah nanti
        $customerName = $product->nama_customer;


        // --- MULAI PROSES HAPUS GAMBAR & DATA ---

        // A. Hapus Gallery
        $gallery = DB::table('product_images')->where('product_id', $id)->get();
        foreach($gallery as $img) {
            if ($img->image_path && Storage::exists('public/' . $img->image_path)) {
                Storage::delete('public/' . $img->image_path);
            }
        }
        DB::table('product_images')->where('product_id', $id)->delete();

        // B. Hapus Parts
        $items = DB::table('product_items')->where('product_id', $id)->get();
        foreach($items as $item) {
            if ($item->foto_item && Storage::exists('public/' . $item->foto_item)) {
                Storage::delete('public/' . $item->foto_item);
            }
        }
        DB::table('product_items')->where('product_id', $id)->delete();

        // C. Hapus Projects
        $projects = DB::table('project_references')->where('product_id', $id)->get();
        foreach($projects as $proj) {
            if ($proj->image_path && Storage::exists('public/' . $proj->image_path)) {
                Storage::delete('public/' . $proj->image_path);
            }
        }
        DB::table('project_references')->where('product_id', $id)->delete();

        // D. Hapus Produk Utama
        DB::table('products')->where('id', $id)->delete();


        // 3. REDIRECT KEMBALI KE HALAMAN CUSTOMER
        // Gunakan variabel $customerName yang sudah kita simpan di langkah no. 2
        return redirect('/customer/' . $customerName)->with('success', 'Barang berhasil dihapus!');
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
        $dimensions = DB::table('product_dimensions')->where('product_id', $id)->get();

        // Load View PDF Satuan (print_product.blade.php)
        $pdf = \PDF::loadView('print_product', compact('product', 'gallery', 'dimensions', 'items', 'projects'));
        $pdf->setPaper('A4', 'portrait');
        
        
        return $pdf->stream('Produk-' . $product->nama_barang . '.pdf');
    }


   public function printCustomer(Request $request) {
        $name = $request->query('name');
        
        $products = DB::table('products')->where('nama_customer', $name)->get();

        if ($products->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada produk untuk customer ini.');
        }

        $data = [];

        foreach($products as $p) {
            $data[] = [
                'product' => $p,
                'gallery' => DB::table('product_images')->where('product_id', $p->id)->get(),
                'items'   => DB::table('product_items')->where('product_id', $p->id)->get(),
                'projects'=> DB::table('project_references')->where('product_id', $p->id)->get(),
                
                // TAMBAHKAN BARIS INI: Ambil data dimensi
                'dimensions' => DB::table('product_dimensions')->where('product_id', $p->id)->get(),
            ];
        }

        $pdf = \PDF::loadView('print_catalog', compact('data', 'name'));
        $pdf->setOption(['isRemoteEnabled' => true]);
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



    // 1. Halaman Kelola Customer
    public function customerManager() {
        if (!session('is_admin')) return redirect('/login');
        
        $customers = DB::table('customers')->orderBy('name', 'asc')->get();
        return view('customers.index', compact('customers'));
    }

    // 2. Simpan Customer Baru
    public function storeCustomer(Request $request) {
        if (!session('is_admin')) return redirect('/login');

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        DB::table('customers')->insert([
            'name' => $request->name,
            'logo_path' => $logoPath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/customers')->with('success', 'Customer berhasil ditambahkan!');
    }

    // 3. Hapus Customer
    public function deleteCustomer($id) {
        if (!session('is_admin')) return redirect('/login');

        $cust = DB::table('customers')->where('id', $id)->first();
        if ($cust && $cust->logo_path) {
            Storage::disk('public')->delete($cust->logo_path);
        }
        
        DB::table('customers')->where('id', $id)->delete();
        return back()->with('success', 'Customer dihapus.');
    }

public function manageData() {
        if (!session('is_admin')) return redirect('/login');

        // UPDATE: Ambil data dari tabel 'customers' yang baru
        // Kita ambil semua kolom karena nanti butuh ID atau logonya
        $customerList = DB::table('customers')->orderBy('name', 'asc')->get();

        $products = DB::table('products')->orderBy('id', 'desc')->get();
        
        return view('input', compact('products', 'customerList')); 
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
        $dimensions = DB::table('product_dimensions')->where('product_id', $id)->get();

        return view('detail_product', compact('product', 'items', 'gallery', 'projects', 'dimensions'));
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
        $dimensions = DB::table('product_dimensions')->where('product_id', $id)->get();
        // Kirim semua data ke view baru 'edit.blade.php'
        return view('edit', compact('product', 'gallery', 'items', 'projects', 'dimensions'));
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
        $dimensions = DB::table('product_dimensions')->where('product_id', $id)->get();
        return view('edits.spec', compact('product', 'gallery', 'dimensions'));
    }

    public function updateSpec(Request $request, $id) {
        // 1. Update Info Utama Produk
        DB::table('products')->where('id', $id)->update([
            'nama_customer' => $request->nama_customer,
            'nama_barang'   => $request->nama_barang,
            'jenis_material'=> $request->jenis_material,
            'finishing'     => $request->finishing,
            'tipe'          => $request->tipe,
            'color_available' => $request->color_available,
            'price'           => $request->price,
            'updated_at'    => now(),
        ]);

        // 2. Update Gallery (Logic Lama - Sudah Benar)
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

        // 3. UPDATE DIMENSI (Logic Baru: Hapus Semua -> Insert Ulang)
        // Ini cara paling aman untuk one-to-many editing
        if ($request->has('dim_panjang')) {
            // A. Hapus dimensi lama
            DB::table('product_dimensions')->where('product_id', $id)->delete();

            // B. Masukkan dimensi baru dari form edit
            $panjang = $request->dim_panjang;
            $lebar   = $request->dim_lebar;
            $tinggi  = $request->dim_tinggi;
            $kedalam = $request->dim_kedalaman;
            $codes   = $request->dim_item_code;

            for ($i = 0; $i < count($panjang); $i++) {
                if (!empty($panjang[$i]) || !empty($lebar[$i])) {
                    DB::table('product_dimensions')->insert([
                        'product_id' => $id,
                        'panjang'    => $panjang[$i],
                        'lebar'      => $lebar[$i],
                        'tinggi'     => $tinggi[$i],
                        'kedalaman'  => $kedalam[$i],
                        'item_code'  => $codes[$i],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        return redirect('/detail/' . $id . '#spec')->with('success', 'Spesifikasi & Dimensi berhasil diupdate!');
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
        // 1. Hapus Part yang dicentang
        if ($request->has('delete_part_ids')) {
            // Opsional: Hapus file gambarnya juga
            $partsToDelete = DB::table('product_items')->whereIn('id', $request->delete_part_ids)->get();
            foreach($partsToDelete as $p) {
                if($p->foto_item) Storage::disk('public')->delete($p->foto_item);
            }
            DB::table('product_items')->whereIn('id', $request->delete_part_ids)->delete();
        }

        // 2. Update/Insert Part
        if ($request->has('items')) {
            // PENTING: Gunakan $key untuk akses File
            foreach ($request->items as $key => $itemData) {
                
                if (empty($itemData['name'])) continue;

                $dataToSave = [
                    'nama_item'     => $itemData['name'],
                    'tipe'          => $itemData['tipe'] ?? null,
                    'dimensi_part'  => $itemData['dimensi'] ?? null,
                    'konfigurasi'   => $itemData['konfigurasi'] ?? null,
                    'load_capacity' => $itemData['load'] ?? null,
                    'updated_at'    => now(),
                ];

                // PERBAIKAN UPLOAD GAMBAR DISINI
                // Cek apakah ada file di index array yang sesuai ($key)
                if ($request->hasFile("items.$key.image")) {
                    $path = $request->file("items.$key.image")->store('uploads', 'public');
                    $dataToSave['foto_item'] = $path;
                }

                if (isset($itemData['id'])) {
                    // Update Item Lama
                    DB::table('product_items')->where('id', $itemData['id'])->update($dataToSave);
                } else {
                    // Insert Item Baru
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