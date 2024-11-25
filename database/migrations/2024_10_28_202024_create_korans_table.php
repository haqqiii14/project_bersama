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
            $table->string('title');
            $table->string('edisi');
            $table->string('pages');
            $table->string('published');
            $table->string('description');
            $table->string('image');
            $table->string('file');
            $table->string('status');
            $table->string('price');
            $table->string('views');
            $table->string('read');
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
