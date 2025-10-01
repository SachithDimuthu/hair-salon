<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use Carbon\Carbon;

class BookService extends Component
{
    public $currentStep = 1;
    public $maxSteps = 5;
    public $services = [];
    public $selectedServiceId = null;
    public $selectedService = null;
    public $bookingDate = null;
    public $bookingTime = null;
    public $availableTimeSlots = [];
    public $selectedStaff = null;
    public $staffMembers = [];
    public $firstName = '';
    public $lastName = '';
    public $email = '';
    public $phone = '';
    public $specialRequests = '';
    public $totalPrice = 0;
    public $estimatedDuration = 60;
    public $message = '';
    public $messageType = 'info';
    public $isConfirmed = false;

    public function mount()
    {
        $this->loadServices();
        $this->loadStaffMembers();
        $this->generateTimeSlots();
    }

    public function render()
    {
        return view('livewire.book-service-professional');
    }

    public function loadServices()
    {
        try {
            $services = Service::all();
            $this->services = $services->map(function ($service) {
                // Map service images to proper paths
                $imagePath = null;
                if ($service->name) {
                    $imageName = str_replace(' ', '_', $service->name) . '.jpg';
                    $imagePath = 'images/Services/' . $imageName;
                    // Check if file exists
                    if (!file_exists(public_path($imagePath))) {
                        $imagePath = null;
                    }
                }
                
                return [
                    '_id' => (string) $service->_id,
                    'name' => $service->name,
                    'description' => $service->description,
                    'base_price' => $service->base_price,
                    'durations' => $service->durations ?? [['minutes' => 60]],
                    'category' => $service->category ?? '',
                    'visibility' => $service->visibility ?? true,
                    'image' => $imagePath
                ];
            })->toArray();
        } catch (\Exception $e) {
            $this->services = [];
            $this->message = 'Unable to load services. Please refresh the page.';
            $this->messageType = 'error';
        }
    }

    public function loadStaffMembers()
    {
        // For now, we'll use dummy staff data. In production, this would come from a Staff model
        $this->staffMembers = [
            [
                'id' => 1,
                'name' => 'Sarah Johnson',
                'specialization' => 'Hair Styling & Coloring',
                'experience' => '5+ years',
                'image' => 'images/staff/sarah.jpg'
            ],
            [
                'id' => 2,
                'name' => 'Emily Chen',
                'specialization' => 'Facial & Skin Care',
                'experience' => '7+ years',
                'image' => 'images/staff/emily.jpg'
            ],
            [
                'id' => 3,
                'name' => 'Maria Garcia',
                'specialization' => 'Nail Care & Art',
                'experience' => '4+ years',
                'image' => 'images/staff/maria.jpg'
            ],
            [
                'id' => 4,
                'name' => 'Any Available Staff',
                'specialization' => 'All Services',
                'experience' => 'Varies',
                'image' => null
            ]
        ];
    }

    public function generateTimeSlots()
    {
        $this->availableTimeSlots = [
            '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
            '12:00', '12:30', '13:00', '13:30', '14:00', '14:30',
            '15:00', '15:30', '16:00', '16:30', '17:00', '17:30'
        ];
    }

    public function selectService($serviceId)
    {
        try {
            $this->selectedServiceId = $serviceId;
            $this->selectedService = collect($this->services)->firstWhere('_id', $serviceId);
            
            if ($this->selectedService) {
                $this->totalPrice = $this->selectedService['base_price'] ?? 0;
                $this->estimatedDuration = $this->selectedService['durations'][0]['minutes'] ?? 60;
                $this->message = 'Service selected successfully!';
                $this->messageType = 'success';
            } else {
                $this->message = 'Service not found. Please try again.';
                $this->messageType = 'error';
            }
        } catch (\Exception $e) {
            $this->message = 'Error selecting service. Please try again.';
            $this->messageType = 'error';
        }
    }

    public function selectTimeSlot($time)
    {
        $this->bookingTime = $time;
        $this->message = 'Time slot selected: ' . $time;
        $this->messageType = 'success';
    }

    public function selectStaff($staffId)
    {
        $this->selectedStaff = collect($this->staffMembers)->firstWhere('id', $staffId);
        $this->message = 'Staff member selected: ' . ($this->selectedStaff['name'] ?? 'Unknown');
        $this->messageType = 'success';
    }

    public function nextStep()
    {
        // Clear previous messages
        $this->message = '';
        
        // Validate current step before proceeding
        if ($this->currentStep == 1 && !$this->selectedServiceId) {
            $this->message = 'Please select a service to continue.';
            $this->messageType = 'error';
            return;
        }
        
        if ($this->currentStep == 2 && !$this->bookingDate) {
            $this->message = 'Please select a date to continue.';
            $this->messageType = 'error';
            return;
        }
        
        if ($this->currentStep == 3 && !$this->bookingTime) {
            $this->message = 'Please select a time slot to continue.';
            $this->messageType = 'error';
            return;
        }
        
        if ($this->currentStep == 4) {
            // Validate customer details
            $rules = [
                'firstName' => 'required|min:2',
                'lastName' => 'required|min:2',
                'email' => 'required|email',
                'phone' => 'required|min:10'
            ];
            
            $this->validate($rules);
        }
        
        if ($this->currentStep < $this->maxSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
            $this->message = '';
        }
    }

    public function confirmBooking()
    {
        try {
            // In a real application, you would save this to a Booking model
            // For now, we'll just show a success message
            
            $this->isConfirmed = true;
            $this->message = 'Booking confirmed successfully! You will receive a confirmation email shortly.';
            $this->messageType = 'success';
            
            // Reset the form for next booking
            $this->resetForm();
            
        } catch (\Exception $e) {
            $this->message = 'Error confirming booking. Please try again.';
            $this->messageType = 'error';
        }
    }

    public function resetForm()
    {
        $this->currentStep = 1;
        $this->selectedServiceId = null;
        $this->selectedService = null;
        $this->bookingDate = null;
        $this->bookingTime = null;
        $this->selectedStaff = null;
        $this->firstName = '';
        $this->lastName = '';
        $this->email = '';
        $this->phone = '';
        $this->specialRequests = '';
        $this->totalPrice = 0;
        $this->estimatedDuration = 60;
    }

    // Validation rules
    protected $rules = [
        'firstName' => 'required|min:2',
        'lastName' => 'required|min:2',
        'email' => 'required|email',
        'phone' => 'required|min:10',
        'bookingDate' => 'required|date|after_or_equal:today',
        'bookingTime' => 'required',
        'selectedServiceId' => 'required'
    ];

    protected $messages = [
        'firstName.required' => 'First name is required.',
        'firstName.min' => 'First name must be at least 2 characters.',
        'lastName.required' => 'Last name is required.',
        'lastName.min' => 'Last name must be at least 2 characters.',
        'email.required' => 'Email address is required.',
        'email.email' => 'Please enter a valid email address.',
        'phone.required' => 'Phone number is required.',
        'phone.min' => 'Phone number must be at least 10 characters.',
        'bookingDate.required' => 'Please select a booking date.',
        'bookingDate.after_or_equal' => 'Booking date must be today or later.',
        'bookingTime.required' => 'Please select a time slot.',
        'selectedServiceId.required' => 'Please select a service.'
    ];
}