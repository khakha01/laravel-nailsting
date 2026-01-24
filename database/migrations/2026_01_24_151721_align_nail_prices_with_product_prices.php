<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('nail_prices', function (Blueprint $table) {
            $table->enum('price_type', ['fixed', 'range', 'per_nail'])->default('fixed')->after('nail_id');
            $table->decimal('price_min', 12, 0)->nullable()->after('price');
            $table->decimal('price_max', 12, 0)->nullable()->after('price_min');
            $table->string('note')->nullable()->after('price_max');
        });

        // Migrate title to note
        DB::table('nail_prices')->update([
            'note' => DB::raw('title'),
            'price_type' => 'fixed'
        ]);

        Schema::table('nail_prices', function (Blueprint $table) {
            $table->dropColumn('title');
            // Keep is_default for now but we might not use it in UI if we want to be 100% same as products
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nail_prices', function (Blueprint $table) {
            $table->string('title')->after('nail_id');
        });

        // Restore title from note
        DB::table('nail_prices')->update([
            'title' => DB::raw('note')
        ]);

        Schema::table('nail_prices', function (Blueprint $table) {
            $table->dropColumn(['price_type', 'price_min', 'price_max', 'note']);
        });
    }
};
