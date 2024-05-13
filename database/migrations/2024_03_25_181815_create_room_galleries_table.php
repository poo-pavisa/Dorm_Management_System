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
        Schema::create('room_galleries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->unsignedInteger('sort_order');
            $table->boolean('is_published');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('UPDATE room_galleries SET sort_order = id');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_galleries');
    }

};
