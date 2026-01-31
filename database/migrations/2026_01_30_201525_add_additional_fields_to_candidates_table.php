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
        Schema::table('candidates', function (Blueprint $table)
        {

            $table->string('reference_no')->nullable()->after('registration_no');
            // Address & personal
            $table->text('address')->nullable()->after('contact_number_2');
            $table->string('place_of_birth')->nullable()->after('dob');

            $table->string('civil_status')->nullable()->after('place_of_birth');
            $table->unsignedTinyInteger('no_of_children')->nullable()->after('civil_status');

            $table->string('nationality')->default('Sri Lankan')->after('no_of_children');
            $table->string('religion')->nullable()->after('nationality');

            // Parents
            $table->string('father_name')->nullable()->after('religion');
            $table->string('mother_name')->nullable()->after('father_name');

            // Physical
            $table->unsignedSmallInteger('height_cm')->nullable()->after('mother_name');
            $table->unsignedSmallInteger('weight_kg')->nullable()->after('height_cm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn([
                'address',
                'place_of_birth',
                'civil_status',
                'no_of_children',
                'nationality',
                'religion',
                'father_name',
                'mother_name',
                'height_cm',
                'weight_kg',
            ]);
        });
    }
};
