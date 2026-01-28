<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('product_prices', function (Blueprint $table) {
            if (Schema::hasColumn('product_prices', 'effective_from')) {
                $table->dropColumn('effective_from');
            }

            if (Schema::hasColumn('product_prices', 'effective_to')) {
                $table->dropColumn('effective_to');
            }
        });
    }

    public function down(): void
    {
        Schema::table('product_prices', function (Blueprint $table) {
            $table->date('effective_from')->nullable();
            $table->date('effective_to')->nullable();
        });
    }
};
