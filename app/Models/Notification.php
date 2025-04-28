<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'username',
        'password',
        'full_name',
        'email',
        'role',
    ];
}
