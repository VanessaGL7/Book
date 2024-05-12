<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chapter extends Model
{
    protected $fillable = [
        'id_book',
        'chapter_name',
        'chapter_content',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}