<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'preferred_date' => 'date',
    ];

    public const STATUSES = [
        'pending' => 'Bekliyor',
        'in_progress' => 'İşlemde',
        'completed' => 'Tamamlandı',
        'cancelled' => 'İptal',
    ];

    protected static function booted(): void
    {
        static::creating(function (Appointment $appointment) {
            if (blank($appointment->reference)) {
                $appointment->reference = 'OTO-' . strtoupper(Str::random(6));
            }
        });
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
