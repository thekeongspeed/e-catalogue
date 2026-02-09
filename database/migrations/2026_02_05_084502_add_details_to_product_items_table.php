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
        $table->string('tipe')->nullable();          // Contoh: Base Leg 
        $table->string('dimensi_part')->nullable();  // Contoh: 30cm x 10cm
        $table->string('konfigurasi')->nullable();   // Contoh: T-Shape
        $table->string('load_capacity')->nullable(); // Contoh: 50kg
    });
}

public function down()
{
    Schema::table('product_items', function (Blueprint $table) {
        $table->dropColumn(['tipe', 'dimensi_part', 'konfigurasi', 'load_capacity']);
    });
}
};
