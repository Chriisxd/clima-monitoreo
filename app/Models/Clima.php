<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Clima extends Model
{
    protected $fillable = [
        'ciudad',
        'temperatura',
        'humedad',
        'condicion_clima',
        'fecha_consulta',
    ];

    protected $casts = [
        'fecha_consulta' => 'datetime',
        'temperatura' => 'float',
    ];

    protected $appends = ['temp_fahrenheit'];

    // Accessor: Celsius → Fahrenheit
    public function getTempFahrenheitAttribute(): float
    {
        return round(($this->temperatura * 9 / 5) + 32, 2);
    }

    // Relación polimórfica
    public function comentarios(): MorphMany
    {
        return $this->morphMany(Comentario::class, 'commentable');
    }
}