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
        Schema::create('distributor_has_item', function (Blueprint $table) {
            $table->id();
			$table->foreignId('distributor_id')->constrained(
				table: 'distributors', indexName: 'distributor_item_id'
			)->onUpdate('cascade')->onDelete('cascade');
			$table->foreignId('item_id')->constrained(
				table: 'items', indexName: 'item_distributor_id'
			)->onUpdate('cascade')->onDelete('cascade');
			$table->integer('count')->default(0);
			$table->decimal('price', total: 8, places: 2);
			$table->integer('discount')->nullable();
			$table->string('delivery')->nullable();
			$table->tinyInteger('is_enabled')->length(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributor_has_item');
    }
};
