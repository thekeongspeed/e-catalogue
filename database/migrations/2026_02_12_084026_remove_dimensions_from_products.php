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
    Schema::table('products', function (Blueprint $table) {
        // Hapus kolom dimensi dari tabel products karena sudah pindah ke tabel lain
        $table->dropColumn(['panjang', 'lebar', 'tinggi', 'kedalaman']);
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        // Backup jika rollback
        $table->string('panjang')->nullable();
        $table->string('lebar')->nullable();
        $table->string('tinggi')->nullable();
        $table->string('kedalaman')->nullable();
    });
}

};
