<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_reminders', function (Blueprint $table) {
            $table->string('locale');
        });
    }

    public function down(): void
    {
        Schema::table('order_reminders', function (Blueprint $table) {
            $table->dropColumn('locale');
        });
    }
};
