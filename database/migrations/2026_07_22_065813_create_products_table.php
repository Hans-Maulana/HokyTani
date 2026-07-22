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
            $table->foreignId('rack_id')->nullable()->constrained('racks')->onDelete('set null');
            $table->string('barcode', 100)->unique()->nullable();
            $table->string('nama', 100);
            $table->string('merk', 100)->nullable();
            $table->integer('harga');
            $table->text('deskripsi')->nullable();
            $table->string('status', 50)->nullable();
            $table->string('foto')->nullable();
            $table->string('lokasi_rak', 100)->nullable();
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
