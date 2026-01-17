<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nail_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nail_id')
                  ->constrained('nails')
                  ->cascadeOnDelete();
            $table->string('title'); // VD: Giá cơ bản, Nail dài
            $table->decimal('price', 12, 0); // tiền VND
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nail_prices');
    }
};
