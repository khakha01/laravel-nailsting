<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            // General tab
            $table->string('email')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('phone3')->nullable();
            $table->string('phone_zalo')->nullable();

            // Social Link tab
            $table->string('link_tiktok')->nullable();
            $table->string('link_fb')->nullable();
            $table->string('link_zalo')->nullable();

            // Image tab
            $table->string('logo_id')->nullable();
            $table->string('favicon_id')->nullable();

            // Options tab
            $table->string('website_name')->nullable();
            $table->text('address')->nullable();
            $table->text('map_iframe')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
