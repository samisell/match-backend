<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image_url',
        'caption',
        'is_primary',
    ];

    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        $path = \Illuminate\Support\Facades\Storage::url($this->image_url);
        return str_starts_with($path, 'http') ? $path : config('app.url') . $path;
    }
}