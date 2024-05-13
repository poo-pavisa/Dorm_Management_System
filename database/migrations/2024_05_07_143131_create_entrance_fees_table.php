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
        Schema::create('entrance_fees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contract_rent_id');
            $table->foreign('contract_rent_id')->references('id')->on('contract_rents')->onDelete('cascade');
            $table->float('sum_payable');
            $table->string('slip')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrance_fees');
    }
};
