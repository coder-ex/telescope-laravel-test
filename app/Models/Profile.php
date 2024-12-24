<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'birthday',
        'email',
        'telegram',
        'phone'
    ];

    protected $casts = [
        'birthday' => 'date:Y-m-d',
    ];
}

