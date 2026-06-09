<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'reference' => 'OTO-' . strtoupper(Str::random(6)),
            'service_id' => Service::query()->inRandomOrder()->value('id'),
            'name' => $this->faker->name(),
            'phone' => $this->faker->numerify('0532 ### ## ##'),
            'email' => $this->faker->safeEmail(),
            'vehicle_make' => $this->faker->randomElement(['BMW', 'Mercedes', 'Audi', 'Ford', 'Renault']),
            'vehicle_model' => $this->faker->randomElement(['320i', 'C180', 'A3', 'Focus', 'Megane']),
            'vehicle_year' => $this->faker->numberBetween(2010, 2024),
            'plate' => strtoupper($this->faker->bothify('## ??? ###')),
            'preferred_date' => now()->addDays($this->faker->numberBetween(1, 14))->toDateString(),
            'preferred_time' => $this->faker->randomElement(['09:00', '10:00', '11:00', '14:00', '15:00']),
            'notes' => null,
            'status' => 'pending',
        ];
    }
}
