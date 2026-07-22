<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('store_grids', function (Blueprint $table) {
            $table->id();
            $table->integer('row_idx');
            $table->integer('col_idx');
            $table->string('zone_type', 50)->default('lorong');
            $table->string('label', 50)->nullable();
            $table->string('color', 50)->default('gray');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_grids');
    }
};
