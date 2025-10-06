<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('order_has_distributor_item', 'propositions');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('propositions', 'order_has_distributor_item');
    }
};
