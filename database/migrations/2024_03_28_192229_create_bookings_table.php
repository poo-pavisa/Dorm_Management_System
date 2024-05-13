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
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('room_id');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->char('phone','10');
            $table->enum('gender', ['Male','Female']);
            $table->date('move_in_date');
            $table->string('note')->nullable();
            $table->tinyInteger('booking_channel')->default(1);
            $table->tinyInteger('status')->default(0);
            $table->boolean('is_sent')->default(false);
            $table->char('booking_ref','12')->nullable()->unique();
            $table->timestamps();
            $table->softDeletes();
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
