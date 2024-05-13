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
        Schema::create('electricity_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dorm_id');
            $table->foreign('dorm_id')->references('id')->on('dormitories')->onDelete('cascade');
            $table->enum('type', ['Flat Rate', 'Base On Meter']);
            $table->float('price_per_unit')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electricity_types');
    }
};
