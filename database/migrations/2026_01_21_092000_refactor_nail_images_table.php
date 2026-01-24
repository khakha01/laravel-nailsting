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
        Schema::table('nail_images', function (Blueprint $table) {
            // Drop the old path column
            $table->dropColumn('image_path');
            
            // Add the new foreign key
            $table->foreignId('media_id')
                  ->after('nail_id')
                  ->constrained('media')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nail_images', function (Blueprint $table) {
            $table->dropForeign(['media_id']);
            $table->dropColumn('media_id');
            $table->string('image_path')->after('nail_id');
        });
    }
};
