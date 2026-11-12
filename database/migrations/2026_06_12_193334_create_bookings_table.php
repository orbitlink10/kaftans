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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->foreignId('service_id')->constrained()->restrictOnDelete();
            $table->unsignedBigInteger('provider_id')->nullable()->index();
            $table->string('booking_number')->unique();
            $table->string('location');
            $table->date('preferred_date');
            $table->time('preferred_time');
            $table->text('description')->nullable();
            $table->enum('urgency', ['normal', 'same-day', 'emergency'])->default('normal');
            $table->decimal('estimated_price', 10, 2)->default(0);
            $table->enum('status', ['pending', 'confirmed', 'assigned', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->enum('provider_status', ['pending', 'accepted', 'rejected', 'on_the_way', 'started', 'completed'])->default('pending');
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
