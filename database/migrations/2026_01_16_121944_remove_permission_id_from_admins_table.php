<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {

            if (Schema::hasColumn('admins', 'permission_id')) {

                // drop FK nếu tồn tại
                try {
                    $table->dropForeign(['permission_id']);
                } catch (\Exception $e) {
                    // bỏ qua nếu không tồn tại
                }

                $table->dropColumn('permission_id');
            }
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            //
        });
    }
};
