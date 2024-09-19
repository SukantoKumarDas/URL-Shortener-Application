<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'original_url',
        'shortened_alias',
        'is_private',
        'expired_at',
        'is_active',
    ];
}
