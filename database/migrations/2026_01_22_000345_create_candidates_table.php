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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('registration_no')->unique();
            $table->string('full_name');
            $table->string('nic')->nullable();
            $table->string('passport_no')->nullable();
            $table->date('passport_expiry')->nullable();
            $table->date('dob')->nullable();
            $table->integer('age')->nullable();
            $table->string('education')->nullable();
            $table->integer('experience_years')->nullable();

            $table->foreignId('country_id')->constrained();
            $table->foreignId('job_id')->constrained();
            $table->foreignId('agent_id')->nullable()->constrained();
            $table->foreignId('sub_dealer_id')->nullable()->constrained();

            $table->string('photo')->nullable();
            $table->string('status')->default('registered');
            $table->foreignId('created_by')->constrained('users');
            $table->unsignedInteger('updated_by')->constrained('users')->nullable();
            $table->unsignedInteger('deleted_by')->constrained('users')->nullable();
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
