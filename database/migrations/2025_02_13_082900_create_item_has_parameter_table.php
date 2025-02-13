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
        Schema::create('item_has_parameter', function (Blueprint $table) {
            $table->id();
			$table->foreignId('item_id')->constrained(
				table: 'items', indexName: 'item_parameter_id'
			)->onUpdate('cascade')->onDelete('cascade');
			$table->foreignId('parameter_id')->constrained(
				table: 'parameters', indexName: 'parameter_item_id'
			)->onUpdate('cascade')->onDelete('cascade');
			$table->string('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_has_parameter');
    }
};
