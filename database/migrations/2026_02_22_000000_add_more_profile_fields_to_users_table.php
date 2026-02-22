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
        Schema::table('users', function (Blueprint $table) {
            // Basic Info
            $table->string('phone')->nullable()->after('email');
            
            // Physical Attributes
            $table->string('height')->nullable()->after('education');
            $table->string('body_type')->nullable()->after('height');
            $table->string('eye_color')->nullable()->after('body_type');
            $table->string('hair_color')->nullable()->after('eye_color');
            
            // Lifestyle
            $table->string('smoking')->nullable()->after('hair_color');
            $table->string('drinking')->nullable()->after('smoking');
            $table->string('drugs')->nullable()->after('drinking');
            
            // Habits & Preferences
            $table->string('dietary_preferences')->nullable()->after('drugs');
            $table->string('exercise_frequency')->nullable()->after('dietary_preferences');
            $table->string('pet_ownership')->nullable()->after('exercise_frequency');
            $table->string('religion')->nullable()->after('pet_ownership');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'height',
                'body_type',
                'eye_color',
                'hair_color',
                'smoking',
                'drinking',
                'drugs',
                'dietary_preferences',
                'exercise_frequency',
                'pet_ownership',
                'religion',
            ]);
        });
    }
};
