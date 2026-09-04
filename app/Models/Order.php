<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'billiards',
        'billiard_id',
        'summa',
        'isBar',
        'month',
        'paid',
        'user_id',
        'rate_id',
        'type',
        'is_way_active',
        'valuta',
    ];

    public function rate()
    {
        return $this->belongsTo(Rate::class);
    }

}
