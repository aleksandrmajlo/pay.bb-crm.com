<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lang extends Model
{
    use HasFactory;
    protected $fillable=['name','slug'];

    public function faqs()
    {
        return $this->belongsToMany(Faq::class, 'faq_tag')
            ->withPivot('tag_id')
            ->withTimestamps();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'faq_tag')
            ->withPivot('faq_id')
            ->withTimestamps();
    }
}
