<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BilliardSmsSetting extends Model
{
    protected $casts = [
        'turbosms_password' => 'encrypted',
        'twillo_token' => 'encrypted',
    ];

    protected $hidden = [
        'turbosms_password',
        'twillo_token',
    ];
}
