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
        Schema::create('electricity_meters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('electricity_type_id');
            $table->foreign('electricity_type_id')->references('id')->on('electricity_types')->onDelete('cascade');
            $table->unsignedBigInteger('room_id');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->float('start_reading');
            $table->float('end_reading');
            $table->float('quantity_consumed');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electricity_meters');
    }
};
