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
        Schema::create('contract_rents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->unsignedBigInteger('bill_booking_id')->nullable();
            $table->foreign('bill_booking_id')->references('id')->on('bill_bookings')->onDelete('cascade');
            $table->date('contract_start_date');
            $table->unsignedInteger('contract_duration');
            $table->date('contract_end_date');
            $table->float('security_deposit');
            $table->float('booking_deduction')->nullable();
            $table->date('booking_payment_date')->nullable();
            $table->char('booking_receipt_ref','12')->nullable();
            $table->float('start_water_reading');
            $table->float('start_electricity_reading');
            $table->string('image')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_rents');
    }
};
