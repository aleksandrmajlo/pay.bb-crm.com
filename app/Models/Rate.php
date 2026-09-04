<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'isBar',
        'month',
        'year',
        'valuta',
        'billiard_id'
    ];

    public function billiard()
    {
        return $this->belongsTo(Billiard::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
