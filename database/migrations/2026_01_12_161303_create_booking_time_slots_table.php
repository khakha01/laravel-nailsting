<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up(): void
    {
        Schema::create('booking_time_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_date_id')->constrained('booking_dates')->cascadeOnDelete();
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_open')->default(true);
            $table->timestamps();
            $table->unique(['booking_date_id', 'start_time', 'end_time'],'unique_time_slot_per_day');// Không cho trùng slot trong cùng 1 ngày
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('booking_time_slots');
    }
};
