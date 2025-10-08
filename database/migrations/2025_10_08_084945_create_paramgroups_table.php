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
        Schema::create('paramgroups', function (Blueprint $table) {
            $table->id();
			$table->string('name');
			$table->integer('order')->default(0);
			$table->tinyInteger('is_enabled')->default(0)->length(1);
            $table->timestamps();
        });
		Schema::table('parameters', function (Blueprint $table) {
			$table->after('unit_id', function (Blueprint $tablename) {
				$tablename->foreignId('paramgroup_id')->nullable()->constrained(
					table: 'paramgroup', indexName: 'parameter_group_id'
				)->onUpdate('cascade')->onDelete('set null');
			});
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
		Schema::table('parameters', function (Blueprint $table) {
			$table->dropForeign('parameter_group_id');
			$table->dropColumn('paramgroup_id');
		});
        Schema::dropIfExists('paramgroups');
    }
};
