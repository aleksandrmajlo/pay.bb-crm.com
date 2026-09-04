<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billiard extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'idd',
        'isBar',
        'isFree',
        'date_end',
    ];

    public function rate()
    {
        return $this->hasOne(Rate::class);
    }
}
