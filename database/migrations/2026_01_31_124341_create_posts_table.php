<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->text('excerpt')->nullable();
            $table->foreignId('post_category_id')->nullable()->constrained('post_categories')->onDelete('set null');
            $table->foreignId('media_id')->nullable()->constrained('media')->onDelete('set null');
            $table->foreignId('author_id')->nullable()->constrained('admins')->onDelete('set null');
            $table->string('status')->default('draft'); // draft, published
            $table->integer('view_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->dateTime('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
