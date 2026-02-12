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
    ];

    protected $casts = [
        'desired_interests' => 'array',
    ];
}