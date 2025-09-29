<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;

class BookService extends Component
{
    #[Validate('required')]
    public $selectedServiceId;
    
    #[Validate('required|date|after:today')]
    public $bookingDate;
    
    public $services;
    public $message = '';
    public $messageType = '';

    public function mount()
    {
        $this->services = Service::where('visibility', true)->where('active', true)->orderBy('category')->get();
    }

    public function bookService()
    {
        $this->validate();

        // Check if customer is authenticated
        if (!Auth::guard('customer')->check()) {
            $this->message = 'Please login to book a service.';
            $this->messageType = 'error';
            return;
        }

        $customer = Auth::guard('customer')->user();
        $service = Service::find($this->selectedServiceId);

        // Check if already booked
        $existingBooking = $customer->services()
            ->where('ServiceID', $this->selectedServiceId)
            ->where('Status', 'booked')
            ->exists();

        if ($existingBooking) {
            $this->message = 'You have already booked this service.';
            $this->messageType = 'error';
            return;
        }

        // Create booking
        $customer->services()->attach($this->selectedServiceId, [
            'BookedAt' => $this->bookingDate,
            'Status' => 'booked'
        ]);

        $this->message = "Successfully booked {$service->ServiceName} for {$this->bookingDate}!";
        $this->messageType = 'success';
        
        // Reset form
        $this->reset(['selectedServiceId', 'bookingDate']);
    }

    public function render()
    {
        return view('livewire.book-service');
    }
}
