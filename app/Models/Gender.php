<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gender extends Model
{
    protected $fillable = [
        'geder_name',
    ];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}