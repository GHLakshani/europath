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
        Schema::table('document_types', function (Blueprint $table) {
            $table->unsignedInteger('deleted_by')->nullable()->after('is_mandatory');
            $table->unsignedInteger('updated_by')->nullable()->after('is_mandatory');
            $table->unsignedInteger('created_by')->nullable()->after('is_mandatory');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_types', function (Blueprint $table) {
            //
        });
    }
};
