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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->unique();
            $table->string('order_date');
            $table->string('customer_name');
            $table->string('customer_address');
            $table->string('customer_contact_number');
            $table->string('order_amount');
            $table->string('order_mop');
            $table->foreignId('assigned_user_id')->constrained('users');
            $table->foreignId('branch_id')->constrained('branches');
            $table->json('file_paths')->nullable();
            $table->string('reason')->nullable();
            $table->string('order_status')->default('for delivery');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
