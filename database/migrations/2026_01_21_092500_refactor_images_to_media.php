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

        // 2. Refactor admins table (avatar -> media_id)
        if (Schema::hasTable('admins')) {
            Schema::table('admins', function (Blueprint $table) {
                if (Schema::hasColumn('admins', 'avatar')) {
                    $table->dropColumn('avatar');
                }
                if (!Schema::hasColumn('admins', 'media_id')) {
                    $table->foreignId('media_id')
                          ->nullable()
                          ->after('phone') // Place it where avatar likely was or after logical grouping
                          ->constrained('media')
                          ->nullOnDelete();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse admins
        if (Schema::hasTable('admins')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropForeign(['media_id']);
                $table->dropColumn('media_id');
                $table->string('avatar')->nullable()->after('phone');
            });
        }
    }
};
