<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $table = 'books';

    protected $fillable = [
        'title',
        'id_author',
        'id_gender',
    ];

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    public function chapter(): HasMany
    {
        return $this->hasMany(Chapter::class);
    }
    
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

}