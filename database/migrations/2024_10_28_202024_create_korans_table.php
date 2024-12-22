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
        Schema::create('korans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');  // Link to products table
            $table->string('title');
            $table->string('edisi');
            $table->integer('pages');  // Assuming 'pages' should be an integer
            $table->date('published');  // Assuming 'published' should be a date
            $table->text('description');  // Changed to text for longer descriptions
            $table->string('image');
            $table->string('file');
            $table->string('status');
            $table->integer('read')->default(0);  // Assuming read should be an integer
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('korans');
    }
};
