<?php

namespace Tests\Feature;

use App\Livewire\AppointmentForm;
use App\Models\Appointment;
use App\Models\Service;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_public_pages_load(): void
    {
        $this->get('/')->assertOk()->assertSee('OtoPro');
        $this->get('/hizmetler')->assertOk();
        $this->get('/randevu')->assertOk();
        $this->get('/markalar')->assertOk();
        $this->get('/galeri')->assertOk();
        $this->get('/blog')->assertOk();
        $this->get('/iletisim')->assertOk();
    }

    public function test_service_detail_loads(): void
    {
        $service = Service::first();
        $this->get("/hizmetler/{$service->slug}")->assertOk()->assertSee($service->name);
    }

    public function test_admin_login_is_reachable(): void
    {
        $this->get('/admin/login')->assertOk();
    }

    public function test_appointment_can_be_booked_through_the_wizard(): void
    {
        $service = Service::first();
        // Pick the next Monday so the workshop is open with capacity.
        $date = Carbon::today()->next(Carbon::MONDAY)->toDateString();

        Livewire::test(AppointmentForm::class)
            ->call('selectService', $service->id)
            ->assertSet('step', 2)
            ->set('vehicle_make', 'BMW')
            ->set('vehicle_model', '320i')
            ->set('vehicle_year', 2020)
            ->call('nextFromVehicle')
            ->assertSet('step', 3)
            ->set('preferred_date', $date)
            ->call('selectSlot', '10:00')
            ->call('nextFromDate')
            ->assertSet('step', 4)
            ->set('name', 'Test Müşteri')
            ->set('phone', '0532 000 00 00')
            ->call('submit')
            ->assertSet('done', true);

        $this->assertDatabaseHas('appointments', [
            'name' => 'Test Müşteri',
            'vehicle_make' => 'BMW',
            'preferred_date' => $date . ' 00:00:00',
            'preferred_time' => '10:00',
            'status' => 'pending',
        ]);
    }

    public function test_full_slot_is_not_bookable(): void
    {
        $service = Service::first();
        $date = Carbon::today()->next(Carbon::TUESDAY)->toDateString();

        // Fill the 10:00 slot to its capacity (3 on weekdays).
        Appointment::factory()->count(3)->create([
            'service_id' => $service->id,
            'preferred_date' => $date,
            'preferred_time' => '10:00',
            'status' => 'pending',
        ]);

        $component = Livewire::test(AppointmentForm::class)
            ->call('selectService', $service->id)
            ->set('vehicle_make', 'Ford')
            ->set('vehicle_model', 'Focus')
            ->call('nextFromVehicle')
            ->set('preferred_date', $date)
            ->call('selectSlot', '10:00')
            ->call('nextFromDate');

        // Capacity reached -> cannot advance past the date step.
        $component->assertSet('step', 3)->assertHasErrors('preferred_time');
    }
}
