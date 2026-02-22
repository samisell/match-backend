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
        Schema::table('user_preferences', function (Blueprint $table) {
            $table->string('gender_preference')->nullable()->after('location_radius_km');
            $table->string('height_min')->nullable()->after('gender_preference');
            $table->string('height_max')->nullable()->after('height_min');
            $table->json('preferred_body_types')->nullable()->after('height_max');
            $table->string('smoking_preference')->nullable()->after('preferred_body_types');
            $table->string('drinking_preference')->nullable()->after('smoking_preference');
            $table->string('drugs_preference')->nullable()->after('drinking_preference');
            $table->string('religion_preference')->nullable()->after('drugs_preference');
            $table->string('education_level_preference')->nullable()->after('religion_preference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_preferences', function (Blueprint $table) {
            $table->dropColumn([
                'gender_preference',
                'height_min',
                'height_max',
                'preferred_body_types',
                'smoking_preference',
                'drinking_preference',
                'drugs_preference',
                'religion_preference',
                'education_level_preference',
            ]);
        });
    }
};
