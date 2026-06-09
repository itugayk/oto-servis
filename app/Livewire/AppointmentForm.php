<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Service;
use App\Services\AppointmentAvailability;
use Illuminate\Support\Carbon;
use Livewire\Component;

class AppointmentForm extends Component
{
    public int $step = 1;

    // Step 1 — service
    public ?int $service_id = null;

    // Step 2 — vehicle
    public string $vehicle_make = '';
    public string $vehicle_model = '';
    public ?int $vehicle_year = null;
    public string $plate = '';

    // Step 3 — date & slot
    public ?string $preferred_date = null;
    public ?string $preferred_time = null;

    // Step 4 — contact
    public string $name = '';
    public string $phone = '';
    public string $email = '';
    public string $notes = '';

    public bool $done = false;
    public ?string $reference = null;

    public function mount(?int $service = null): void
    {
        if ($service && Service::whereKey($service)->exists()) {
            $this->service_id = $service;
        }
        $this->preferred_date = Carbon::today()->addDay()->toDateString();
    }

    public function getServicesProperty()
    {
        return Service::active()->orderBy('sort_order')->get();
    }

    public function getSlotsProperty()
    {
        if (! $this->preferred_date) {
            return collect();
        }

        return app(AppointmentAvailability::class)->slotsForDate($this->preferred_date);
    }

    public function getMinDateProperty(): string
    {
        return Carbon::today()->toDateString();
    }

    public function getMaxDateProperty(): string
    {
        return Carbon::today()->addDays(60)->toDateString();
    }

    public function updatedPreferredDate(): void
    {
        // Reset chosen slot when the date changes.
        $this->preferred_time = null;
    }

    public function selectService(int $id): void
    {
        $this->service_id = $id;
        $this->step = 2;
    }

    public function selectSlot(string $time): void
    {
        $this->preferred_time = $time;
    }

    public function goTo(int $step): void
    {
        // Only allow navigating back to earlier steps.
        if ($step < $this->step) {
            $this->step = $step;
        }
    }

    public function nextFromVehicle(): void
    {
        $this->validate([
            'vehicle_make' => 'required|string|max:60',
            'vehicle_model' => 'required|string|max:60',
            'vehicle_year' => 'nullable|integer|min:1950|max:' . (date('Y') + 1),
            'plate' => 'nullable|string|max:20',
        ]);
        $this->step = 3;
    }

    public function nextFromDate(): void
    {
        $this->validate([
            'preferred_date' => 'required|date|after_or_equal:today',
            'preferred_time' => 'required|string',
        ], [
            'preferred_time.required' => 'Lütfen uygun bir saat seçin.',
        ]);

        if (! app(AppointmentAvailability::class)->isSlotAvailable($this->preferred_date, $this->preferred_time)) {
            $this->addError('preferred_time', 'Seçtiğiniz saat dolmuş, lütfen başka bir saat seçin.');

            return;
        }

        $this->step = 4;
    }

    public function submit(): void
    {
        $this->validate([
            'service_id' => 'required|exists:services,id',
            'vehicle_make' => 'required|string|max:60',
            'vehicle_model' => 'required|string|max:60',
            'preferred_date' => 'required|date|after_or_equal:today',
            'preferred_time' => 'required|string',
            'name' => 'required|string|max:120',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:120',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Final capacity re-check to avoid double booking.
        if (! app(AppointmentAvailability::class)->isSlotAvailable($this->preferred_date, $this->preferred_time)) {
            $this->step = 3;
            $this->preferred_time = null;
            $this->addError('preferred_time', 'Seçtiğiniz saat az önce doldu, lütfen yeni bir saat seçin.');

            return;
        }

        $appointment = Appointment::create([
            'service_id' => $this->service_id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email ?: null,
            'vehicle_make' => $this->vehicle_make,
            'vehicle_model' => $this->vehicle_model,
            'vehicle_year' => $this->vehicle_year,
            'plate' => $this->plate ?: null,
            'preferred_date' => $this->preferred_date,
            'preferred_time' => $this->preferred_time,
            'notes' => $this->notes ?: null,
            'status' => 'pending',
        ]);

        $this->reference = $appointment->reference;
        $this->done = true;
    }

    public function resetForm(): void
    {
        $this->reset();
        $this->mount();
    }

    public function render()
    {
        return view('livewire.appointment-form');
    }
}
