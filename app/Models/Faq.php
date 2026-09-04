<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'question_uk',
        'answer',
        'answer_uk',
        'sort',
        'status',
        'tag_id',
        'search'
    ];

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)
            ->withPivot('lang_id')
            ->withTimestamps();
    }

    // Если нужно получать языки, связанные с конкретными тегами FAQ
    public function langs()
    {
        return $this->belongsToMany(Lang::class, 'faq_tag')
            ->withPivot('tag_id')
            ->withTimestamps();
    }

}
