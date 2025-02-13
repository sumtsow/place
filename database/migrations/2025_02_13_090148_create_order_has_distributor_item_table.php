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
        Schema::create('order_has_distributor_item', function (Blueprint $table) {
            $table->id();
			$table->foreignId('order_id')->constrained(
				table: 'orders', indexName: 'order_distributor_item_id'
			)->onUpdate('cascade')->onDelete('cascade');
			$table->foreignId('distributor_item_id')->constrained(
				table: 'distributor_has_item', indexName: 'distributor_item_order_id'
			)->onUpdate('cascade')->onDelete('cascade');
			$table->integer('count')->default(1);
			$table->dateTime('expired')->nullable();
			$table->tinyInteger('is_enabled')->length(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_has_distributor_item');
    }
};
