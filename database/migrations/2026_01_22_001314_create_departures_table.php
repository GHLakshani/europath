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
        Schema::create('departures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained()->cascadeOnDelete();

            $table->string('ticket_no')->nullable();
            $table->string('flight_no')->nullable();
            $table->date('departure_date')->nullable();

            $table->enum('status', [
                'pending',
                'ticket_issued',
                'departed',
                'cancelled'
            ])->default('pending');

            $table->text('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departures');
    }
};
