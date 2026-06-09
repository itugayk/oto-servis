<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\WorkingHour;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AppointmentAvailability
{
    /**
     * Return the list of bookable time slots for a given date,
     * each annotated with remaining capacity.
     *
     * @return Collection<int, array{time: string, remaining: int, available: bool}>
     */
    public function slotsForDate(string $date): Collection
    {
        $carbon = Carbon::parse($date);
        $hours = WorkingHour::where('day', (int) $carbon->dayOfWeek)->first();

        if (! $hours || ! $hours->is_open) {
            return collect();
        }

        $open = Carbon::parse($date . ' ' . $hours->open_time);
        $close = Carbon::parse($date . ' ' . $hours->close_time);
        $step = max(15, (int) $hours->slot_minutes);

        // Booked counts grouped by slot for this date (active appointments only).
        $booked = Appointment::whereDate('preferred_date', $carbon->toDateString())
            ->whereIn('status', ['pending', 'in_progress'])
            ->selectRaw('preferred_time, COUNT(*) as c')
            ->groupBy('preferred_time')
            ->pluck('c', 'preferred_time');

        $slots = collect();
        $cursor = $open->copy();
        $now = Carbon::now();

        while ($cursor->copy()->addMinutes($step) <= $close) {
            $label = $cursor->format('H:i');
            $used = (int) ($booked[$label] ?? 0);
            $remaining = max(0, $hours->capacity - $used);

            // Disallow slots already in the past for today.
            $isPast = $carbon->isToday() && $cursor->lessThanOrEqualTo($now);

            $slots->push([
                'time' => $label,
                'remaining' => $remaining,
                'available' => $remaining > 0 && ! $isPast,
            ]);

            $cursor->addMinutes($step);
        }

        return $slots;
    }

    public function isSlotAvailable(string $date, string $time): bool
    {
        return $this->slotsForDate($date)
            ->firstWhere('time', $time)['available'] ?? false;
    }
}
