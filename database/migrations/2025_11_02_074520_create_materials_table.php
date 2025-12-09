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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id');
            $table->string('nama_material');
            $table->enum('jenis_logam', ['baja', 'aluminium', 'tembaga', 'kuningan', 'stainless_steel', 'besi', 'magnesium', 'titanium']);
            $table->string('grade');
            $table->text('spesifikasi_teknis')->nullable(); // text, nullable
            $table->decimal('harga_per_kg', 12, 2); // decimal(12,2)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
