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
        Schema::table('order_has_distributor_item', function (Blueprint $table) {
			$table->tinyInteger('is_enabled')->default(0)->length(1)->change();
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_has_distributor_item', function (Blueprint $table) {
			$table->tinyInteger('is_enabled')->length(1)->change();
		});
    }
};
