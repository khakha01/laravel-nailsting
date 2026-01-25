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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            // Main image for the parent banner
            $table->foreignId('media_id')->nullable()->constrained('media')->onDelete('set null');

            $table->string('title')->nullable();
            $table->text('description_1')->nullable();
            $table->text('description_2')->nullable();
            $table->text('description_3')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('banner_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('banner_id')->constrained('banners')->onDelete('cascade');
            // Image for the child banner item
            $table->foreignId('media_id')->nullable()->constrained('media')->onDelete('set null');

            $table->string('title')->nullable();
            $table->text('description_1')->nullable();
            $table->text('description_2')->nullable();
            $table->text('description_3')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();

            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner_items');
        Schema::dropIfExists('banners');
    }
};
