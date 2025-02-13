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
        Schema::create('parameters', function (Blueprint $table) {
            $table->id();
			$table->foreignId('unit_id')->nullable()->constrained(
				table: 'units', indexName: 'parameter_unit_id'
			)->onUpdate('cascade')->onDelete('set null');
			$table->string('name');
			$table->tinyInteger('is_enabled')->length(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameters');
    }
};
