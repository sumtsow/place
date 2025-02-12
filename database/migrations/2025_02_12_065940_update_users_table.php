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
		Schema::table('users', function (Blueprint $table) {
			$table->renameColumn('name', 'firstname');
			$table->string('patronymic')->nullable()->after('firstname');
			$table->string('lastname')->nullable()->after('patronymic');
			$table->tinyInteger('is_enabled')->length(1)->after('lastname');
			$table->string('address', length: 511)->nullable()->after('is_enabled');
			$table->date('birthdate')->nullable()->after('address');
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
			$table->renameColumn('firstname', 'name');
			$table->dropColumn([ 'patronymic', 'lastname', 'is_enabled', 'address', 'birthdate' ]);
		});
    }
};
