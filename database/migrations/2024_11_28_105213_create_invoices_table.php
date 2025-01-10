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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->unique(); // Unique invoice code
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users
            $table->foreignId('subscription_id')->nullable()->constrained()->onDelete('cascade'); // Nullable for manual payments
            $table->decimal('amount', 15, 2); // Amount with two decimal places
            $table->integer('unique_code')->nullable(); // Unique payment code
            $table->enum('status', ['unpaid', 'paid', 'cancelled'])->default('unpaid'); // Payment status
            $table->date('due_date')->nullable(); // Due date for payment
            $table->json('cart_items')->nullable(); // Store cart items as JSON
            $table->string('payment_proof')->nullable(); // Store payment proof path
            $table->timestamps(); // created_at and updated_at
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
