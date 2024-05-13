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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('floor_id');
            $table->foreign('floor_id')->references('id')->on('floors')->onDelete('cascade');
            $table->unsignedInteger('room_no');
            $table->float('monthly_rate');
            $table->float('security_deposit');
            $table->float('deposit');
            $table->text('detail')->nullable();
            $table->string('image')->nullable();
            // ว่าง = 1 , ไม่ว่าง = 0 
            $table->boolean('is_available')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
