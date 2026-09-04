<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'lang_id'];

    public function faqs()
    {
        return $this->belongsToMany(Faq::class)
            ->withPivot('lang_id')
            ->withTimestamps();
    }

    public function lang()
    {
        return $this->belongsTo(Lang::class);
    }

    public function langs()
    {
        return $this->belongsToMany(Lang::class, 'faq_tag')
            ->withPivot('faq_id')
            ->withTimestamps();
    }
}
