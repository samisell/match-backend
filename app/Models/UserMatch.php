<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'matched_user_id',
        'status',
        'matchmaker_note',
        'matched_at',
    ];
}