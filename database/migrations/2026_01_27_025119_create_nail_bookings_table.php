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
        Schema::create('nail_bookings', function (Blueprint $table) {
            $table->id();

            // Customer Information
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();

            // Nail Information
            $table->foreignId('nail_id')->constrained('nails')->onDelete('cascade');
            $table->decimal('nail_price', 10, 2)->default(0);

            // Booking Date & Time
            $table->date('booking_date');
            $table->time('booking_time');

            // Payment Information
            $table->decimal('deposit_amount', 10, 2)->default(50000); // Fixed 50k deposit
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('remaining_amount', 10, 2)->default(0);
            $table->string('payment_proof')->nullable(); // Bill upload

            // Status
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['unpaid', 'deposit_paid', 'fully_paid'])->default('unpaid');

            // Notes
            $table->text('notes')->nullable();

            // Terms acceptance
            $table->boolean('terms_accepted')->default(false);

            // Admin notes
            $table->text('admin_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('customer_phone');
            $table->index('booking_date');
            $table->index('status');
            $table->index('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nail_bookings');
    }
};
