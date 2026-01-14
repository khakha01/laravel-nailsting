<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->nullable()->unique();
            $table->text('description')->nullable();
            $table->string('unit')->default('lần'); // enum: lần, móng, bộ, đôi, cặp, bộ 10 móng, bộ gel
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();

            $table->index('category_id');
            $table->index('is_active');
            $table->index('display_order');
        });

        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->enum('price_type', ['fixed', 'range', 'per_nail'])->default('fixed'); // Loại giá: cố định, khoảng, từng móng
            $table->decimal('price', 10, 2)->nullable(); // Giá cố định
            $table->decimal('price_min', 10, 2)->nullable(); // Giá tối thiểu (dùng cho range/per_nail)
            $table->decimal('price_max', 10, 2)->nullable(); // Giá tối đa (dùng cho range)
            $table->string('note')->nullable(); // Ghi chú (vd: "Gel cao cấp", "Sơn thường")
            $table->timestamps();

            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_prices');
        Schema::dropIfExists('products');
    }
};
