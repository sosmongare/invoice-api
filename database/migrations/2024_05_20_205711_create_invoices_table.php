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
            $table->string('invoice_number');
            $table->date('invoice_date');
            $table->date('due_date')->nullable();
            $table->string('from_name');
            $table->string('from_address');
            $table->string('from_pin')->nullable();
            $table->string('from_email')->nullable();
            $table->string('from_phone')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_bank')->nullable();
            $table->string('payment_branch')->nullable();
            $table->string('payment_name')->nullable();
            $table->string('payment_account')->nullable();
            $table->string('payment_pin')->nullable();
            $table->string('payment_phone')->nullable();
            // customer details
            $table->string('customer_name');
            $table->text('customer_address');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2)->nullable();
            $table->decimal('total', 10, 2);
            $table->string('payment_terms')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
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
