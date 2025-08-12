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
		Schema::table('category_has_item', function (Blueprint $table) {
			$table->tinyInteger('is_main')->length(1)->default(0)->change();
			$table->unique( ['category_id', 'item_id'] );
		});
		Schema::table('distributor_has_item', function (Blueprint $table) {
			$table->tinyInteger('is_enabled')->length(1)->default(0)->change();
			$table->unique( ['distributor_id', 'item_id'] );
		});
		Schema::table('item_has_parameter', function (Blueprint $table) {
			$table->unique( ['parameter_id', 'item_id'] );
		});
		Schema::table('order_has_distributor_item', function (Blueprint $table) {
			$table->unique( ['order_id', 'distributor_item_id'] );
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
		Schema::table('category_has_item', function (Blueprint $table) {
			$table->tinyInteger('is_main')->length(1)->change();
			Schema::disableForeignKeyConstraints();
			$table->dropUnique( ['category_id', 'item_id'] );
			Schema::enableForeignKeyConstraints();
		});
		Schema::table('distributor_has_item', function (Blueprint $table) {
			$table->tinyInteger('is_enabled')->length(1)->change();
			Schema::disableForeignKeyConstraints();
			$table->dropUnique( ['distributor_id', 'item_id'] );
			Schema::enableForeignKeyConstraints();
		});
		Schema::table('item_has_parameter', function (Blueprint $table) {
			Schema::disableForeignKeyConstraints();
			$table->dropUnique( ['parameter_id', 'item_id'] );
			Schema::enableForeignKeyConstraints();
		});
		Schema::table('order_has_distributor_item', function (Blueprint $table) {
			Schema::disableForeignKeyConstraints();
			$table->dropUnique( ['order_id', 'distributor_item_id'] );
			Schema::enableForeignKeyConstraints();
		});
    }
};
