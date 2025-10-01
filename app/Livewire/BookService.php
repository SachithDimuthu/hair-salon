<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BookService extends Component
{
    public $currentStep = 1;
    public $maxSteps = 4;
    public $services = [];
    public $selectedServiceId = null;
    public $selectedService = null;
    public $bookingDate = null;
    public $bookingTime = null;
    public $availableTimeSlots = [];
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
        Log::info('BookService component mounting');
        $this->loadServices();
        $this->generateTimeSlots();
        Log::info('BookService component mounted successfully');
    }

    public function render()
    {
        Log::info('BookService render method called');
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
                
                // Ensure we always have required fields
                return [
                    '_id' => (string) ($service->_id ?? $service->id ?? uniqid()),
                    'name' => $service->name ?? 'Unknown Service',
                    'description' => $service->description ?? '',
                    'base_price' => $service->base_price ?? 0,
                    'durations' => $service->durations ?? [['minutes' => 60]],
                    'category' => $service->category ?? '',
                    'visibility' => $service->visibility ?? true,
                    'image' => $imagePath
                ];
            })->toArray();
            
            Log::info('Services loaded successfully', ['count' => count($this->services)]);
        } catch (\Exception $e) {
            Log::error('Error loading services', ['error' => $e->getMessage()]);
            $this->services = [];
            $this->message = 'Unable to load services. Please refresh the page.';
            $this->messageType = 'error';
        }
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
            // Validate customer details before allowing to proceed
            $rules = [
                'firstName' => 'required|min:2',
                'lastName' => 'required|min:2',
                'email' => 'required|email',
                'phone' => 'required|min:10'
            ];
            
            try {
                $this->validate($rules);
            } catch (\Illuminate\Validation\ValidationException $e) {
                $this->message = 'Please fill in all required fields correctly.';
                $this->messageType = 'error';
                return;
            }
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
        // Debug: Log that method was called
        Log::info('confirmBooking method called');
        
        try {
            // Validate all required fields before confirming
            $rules = [
                'firstName' => 'required|min:2',
                'lastName' => 'required|min:2', 
                'email' => 'required|email',
                'phone' => 'required|min:10',
                'selectedServiceId' => 'required',
                'bookingDate' => 'required|date',
                'bookingTime' => 'required'
            ];
            
            Log::info('About to validate booking data', [
                'firstName' => $this->firstName,
                'lastName' => $this->lastName,
                'email' => $this->email,
                'phone' => $this->phone,
                'selectedServiceId' => $this->selectedServiceId,
                'bookingDate' => $this->bookingDate,
                'bookingTime' => $this->bookingTime
            ]);
            
            $this->validate($rules);
            
            Log::info('Validation passed, saving booking to database');
            
            // Save booking to database
            $booking = $this->saveBooking();
            
            if ($booking) {
                // Set confirmation state
                $this->isConfirmed = true;
                $this->message = 'Booking confirmed successfully! You will receive a confirmation email shortly.';
                $this->messageType = 'success';
                
                Log::info('Booking saved successfully', ['booking_id' => $booking->id]);
                
                // Emit event for potential toast notification
                $this->dispatch('notify', [
                    'type' => 'success',
                    'message' => 'Booking confirmed successfully!',
                    'title' => 'Success'
                ]);
            } else {
                throw new \Exception('Failed to save booking to database');
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            $this->message = 'Please fill in all required fields correctly.';
            $this->messageType = 'error';
            
            // Emit error notification
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Please fill in all required fields correctly.',
                'title' => 'Validation Error'
            ]);
        } catch (\Exception $e) {
            Log::error('Booking confirmation error', ['error' => $e->getMessage()]);
            $this->message = 'Error confirming booking. Please try again.';
            $this->messageType = 'error';
            
            // Emit error notification
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Error confirming booking. Please try again.',
                'title' => 'Booking Error'
            ]);
        }
    }

    private function saveBooking()
    {
        try {
            // Get current user if authenticated
            $customerId = Auth::check() ? Auth::id() : null;
            
            // Prepare booking data
            $bookingData = [
                'customer_id' => $customerId,
                'customer_first_name' => $this->firstName,
                'customer_last_name' => $this->lastName,
                'customer_email' => $this->email,
                'customer_phone' => $this->phone,
                'service_id' => $this->selectedServiceId,
                'service_name' => $this->selectedService['name'] ?? 'Unknown Service',
                'service_price' => $this->selectedService['base_price'] ?? 0,
                'booking_date' => $this->bookingDate,
                'booking_time' => $this->bookingTime,
                'duration_minutes' => $this->estimatedDuration,
                'total_price' => $this->totalPrice,
                'special_requests' => $this->specialRequests,
                'status' => 'pending'
            ];
            
            Log::info('Creating booking with data', $bookingData);
            
            // Create booking
            $booking = Booking::create($bookingData);
            
            Log::info('Booking created successfully', ['booking_id' => $booking->id]);
            
            return $booking;
            
        } catch (\Exception $e) {
            Log::error('Error saving booking', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    public function startNewBooking()
    {
        // Method to reset form for a new booking
        $this->resetForm();
        $this->isConfirmed = false;
        $this->message = '';
    }

    public function resetForm()
    {
        $this->currentStep = 1;
        $this->selectedServiceId = null;
        $this->selectedService = null;
        $this->bookingDate = null;
        $this->bookingTime = null;
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