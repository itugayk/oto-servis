<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AppointmentStats extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Bekleyen randevu', Appointment::where('status', 'pending')->count())
                ->description('Onay bekliyor')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            Stat::make('İşlemdeki araç', Appointment::where('status', 'in_progress')->count())
                ->description('Serviste')
                ->descriptionIcon('heroicon-m-wrench')
                ->color('info'),
            Stat::make('Bugünkü randevu', Appointment::whereDate('preferred_date', today())->count())
                ->description(now()->translatedFormat('d F Y'))
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary'),
            Stat::make('Tamamlanan', Appointment::where('status', 'completed')->count())
                ->description('Toplam')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }
}
