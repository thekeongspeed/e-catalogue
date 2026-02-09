<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
          $table->id();
        $table->string('nama_customer'); // Kategori Toko
        $table->string('nama_barang');
        $table->string('nama_item');
        // Dimensi
        $table->decimal('panjang', 10, 2);
        $table->decimal('lebar', 10, 2);
        $table->decimal('tinggi', 10, 2);
        $table->decimal('kedalaman', 10, 2)->nullable();
        // Spek
        $table->string('jenis_material');
        $table->string('finishing');
        // Gambar (Path)
        $table->string('foto_barang')->nullable();
        $table->string('foto_item')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
