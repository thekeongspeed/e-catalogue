<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('product_items', function (Blueprint $table) {
        // Cek dulu biar tidak error kalau kolom sudah ada
        if (!Schema::hasColumn('product_items', 'tipe')) {
            $table->string('tipe')->nullable();
        }
        if (!Schema::hasColumn('product_items', 'dimensi_part')) {
            $table->string('dimensi_part')->nullable();
        }
        if (!Schema::hasColumn('product_items', 'konfigurasi')) {
            $table->string('konfigurasi')->nullable();
        }
        if (!Schema::hasColumn('product_items', 'load_capacity')) {
            $table->string('load_capacity')->nullable();
        }
    });
}

public function down()
{
    Schema::table('product_items', function (Blueprint $table) {
        $table->dropColumn(['tipe', 'dimensi_part', 'konfigurasi', 'load_capacity']);
    });
}
};
