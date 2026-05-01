<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_reminders', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->integer('timespan');
            $table->date('renewal_date')->nullable();
            $table->timestamps();
        });

        Schema::create('order_reminder_product', function (Blueprint $table) {
            $table->foreignId('order_reminder_id')->constrained('order_reminders')->cascadeOnDelete();
            $table->string('product_sku')->references('sku')->on('catalog_product_entity')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_reminder_product');
        Schema::dropIfExists('order_reminders');
    }
};
