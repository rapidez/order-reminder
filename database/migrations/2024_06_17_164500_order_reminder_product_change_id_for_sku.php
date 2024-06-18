<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_reminder_product', function (Blueprint $table) {
            $table->dropForeign(['product_entity_id']);
            $table->dropColumn('product_entity_id');
            $table->string('product_sku')->references('sku')->on('catalog_product_entity')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('order_reminder_product', function (Blueprint $table) {
            $table->dropColumn('product_sku');
            $table->unsignedInteger('product_entity_id');
            $table->foreign('product_entity_id')->references('entity_id')->on('catalog_product_entity')->onDelete('cascade');
        });
    }
};
