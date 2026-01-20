<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comentario extends Model
{
    protected $fillable = [
        'user_id',
        'contenido',
    ];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}