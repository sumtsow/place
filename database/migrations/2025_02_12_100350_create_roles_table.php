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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
			$table->foreignId('user_id')->constrained(
				table: 'users', indexName: 'roles_user_id'
			)->onUpdate('cascade')->onDelete('cascade');
			$table->enum('name', ['admin', 'operator', 'manager', 'customer']);
			$table->tinyInteger('is_enabled')->length(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
