<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Staff;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Validate;

class AppointmentBooking extends Component
{
    #[Validate('required|string|max:255')]
    public $customer_name = '';

    #[Validate('required|email|max:255')]
    public $customer_email = '';

    #[Validate('required|string|max:20')]
    public $customer_phone = '';

    #[Validate('required|date|after:today')]
    public $appointment_date = '';

    #[Validate('required|string')]
    public $start_time = '';

    #[Validate('required|exists:services,id')]
    public $service_id = '';

    #[Validate('required|exists:staff,id')]
    public $staff_id = '';

    #[Validate('nullable|string|max:500')]
    public $notes = '';

    public $services = [];
    public $staff_members = [];
    public $available_times = [];
    public $selected_service = null;
    public $total_amount = 0;

    public function mount()
    {
        $this->services = Service::where('is_active', true)->orderBy('name')->get();
        $this->staff_members = Staff::where('is_active', true)->orderBy('name')->get();
        $this->appointment_date = Carbon::tomorrow()->format('Y-m-d');
    }

    public function updatedServiceId()
    {
        if ($this->service_id) {
            $this->selected_service = Service::find($this->service_id);
            $this->total_amount = $this->selected_service->base_price;
            $this->loadAvailableTimes();
        }
    }

    public function updatedStaffId()
    {
        $this->loadAvailableTimes();
    }

    public function updatedAppointmentDate()
    {
        $this->loadAvailableTimes();
    }

    public function loadAvailableTimes()
    {
        if (!$this->appointment_date || !$this->staff_id || !$this->service_id) {
            $this->available_times = [];
            return;
        }

        // Generate available time slots (9 AM to 6 PM, 30-minute intervals)
        $times = [];
        $start = Carbon::createFromFormat('Y-m-d H:i', $this->appointment_date . ' 09:00');
        $end = Carbon::createFromFormat('Y-m-d H:i', $this->appointment_date . ' 18:00');

        while ($start->lt($end)) {
            // Check if time slot is available
            $isAvailable = !Appointment::where('staff_id', $this->staff_id)
                ->where('appointment_date', $this->appointment_date)
                ->where('start_time', $start->format('H:i'))
                ->where('status', '!=', 'cancelled')
                ->exists();

            if ($isAvailable) {
                $times[] = $start->format('H:i');
            }

            $start->addMinutes(30);
        }

        $this->available_times = $times;
    }

    public function bookAppointment()
    {
        $this->validate();

        // Find or create customer
        $customer = Customer::firstOrCreate(
            ['email' => $this->customer_email],
            [
                'name' => $this->customer_name,
                'phone' => $this->customer_phone,
            ]
        );

        // Calculate end time based on service duration
        $service = Service::find($this->service_id);
        $start = Carbon::createFromFormat('Y-m-d H:i', $this->appointment_date . ' ' . $this->start_time);
        $end = $start->copy()->addMinutes($service->duration_minutes);

        // Create appointment
        $appointment = Appointment::create([
            'customer_id' => $customer->id,
            'staff_id' => $this->staff_id,
            'appointment_date' => $this->appointment_date,
            'start_time' => $this->start_time,
            'end_time' => $end->format('H:i'),
            'status' => 'scheduled',
            'total_amount' => $this->total_amount,
            'payment_status' => 'pending',
            'notes' => $this->notes,
        ]);

        // Add service to appointment
        $appointment->appointmentServices()->create([
            'service_id' => $this->service_id,
            'staff_id' => $this->staff_id,
            'price' => $this->total_amount,
        ]);

        session()->flash('message', 'Appointment booked successfully!');
        $this->reset(['customer_name', 'customer_email', 'customer_phone', 'start_time', 'service_id', 'staff_id', 'notes']);
        $this->mount();
    }

    public function render()
    {
        return view('livewire.appointment-booking');
    }
}
