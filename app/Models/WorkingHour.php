<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkingHour extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_open' => 'boolean',
    ];

    public const DAYS = [
        1 => 'Pazartesi',
        2 => 'Salı',
        3 => 'Çarşamba',
        4 => 'Perşembe',
        5 => 'Cuma',
        6 => 'Cumartesi',
        0 => 'Pazar',
    ];

    public function getDayNameAttribute(): string
    {
        return self::DAYS[$this->day] ?? '';
    }
}
