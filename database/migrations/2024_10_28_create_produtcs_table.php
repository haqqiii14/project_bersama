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
            $table->string('title'); // Nama produk/paket
            $table->decimal('price', 10, 2); // Harga setelah diskon
            $table->decimal('original_price', 10, 2)->nullable(); // Harga asli sebelum diskon
            $table->unsignedTinyInteger('discount_percentage')->nullable(); // Persentase diskon
            $table->text('description')->nullable(); // Deskripsi produk
            $table->string('duration'); // Durasi paket (contoh: 1 Bulan, 6 Bulan, dll.)
            $table->json('features')->nullable(); // Fitur paket (disimpan dalam format JSON)
            $table->string('image')->nullable(); // Gambar paket
            $table->timestamps(); // Kolom created_at dan updated_at
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
