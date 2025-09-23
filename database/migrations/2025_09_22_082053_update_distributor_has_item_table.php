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
        Schema::table('distributor_has_item', function (Blueprint $table) {
			$table->decimal('price', total: 8, places: 2)->default('0.00')->change();
			$table->tinyInteger('is_enabled')->default(0)->length(1)->change();
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('distributor_has_item', function (Blueprint $table) {
			$table->decimal('price', total: 8, places: 2)->change();
			$table->tinyInteger('is_enabled')->length(1)->change();
		});
    }
};
