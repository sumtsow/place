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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
			$table->foreignId('customer_id')->constrained(
				table: 'roles', indexName: 'order_customer_id'
			)->onUpdate('cascade')->onDelete('cascade');
			$table->tinyInteger('is_enabled')->length(1);
			$table->enum('status', [ 'undefined', 'created', 'confirmed', 'progress', 'completed', 'canceled' ]);
			$table->string('address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
