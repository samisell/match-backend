<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'age_min',
        'age_max',
        'location_radius_km',
        'desired_interests',
        'gender_preference',
        'height_min',
        'height_max',
        'preferred_body_types',
        'smoking_preference',
        'drinking_preference',
        'drugs_preference',
        'religion_preference',
        'education_level_preference',
    ];

    protected $casts = [
        'desired_interests' => 'array',
        'preferred_body_types' => 'array',
    ];
}