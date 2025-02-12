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
        Schema::create('category_has_item', function (Blueprint $table) {
            $table->id();
			$table->foreignId('category_id')->constrained(
				table: 'categories', indexName: 'item_category_id'
			)->onUpdate('cascade')->onDelete('cascade');
			$table->foreignId('item_id')->constrained(
				table: 'items', indexName: 'category_item_id'
			)->onUpdate('cascade')->onDelete('cascade');
			$table->tinyInteger('is_main')->length(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_has_item');
    }
};
