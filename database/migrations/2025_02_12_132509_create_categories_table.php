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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
			$table->foreignId('category_id')->nullable()->constrained(
				table: 'categories', indexName: 'parent_category_id'
			)->onUpdate('cascade')->onDelete('set null');
			$table->string('name');
			$table->tinyInteger('is_enabled')->length(1);
			$table->text('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
