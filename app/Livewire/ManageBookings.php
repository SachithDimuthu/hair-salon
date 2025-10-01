<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Service;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ManageBookings extends Component
{
    use WithPagination;

    // Filters
    public $search = '';
    public $statusFilter = '';
    public $dateFilter = '';
    public $serviceFilter = '';
    
    // Sort
    public $sortBy = 'BookedAt';
    public $sortDirection = 'desc';
    
    // Pagination
    public $perPage = 10;
    
    // Modal state
    public $showBookingModal = false;
    public $selectedBooking = null;
    public $newStatus = '';
    public $adminNotes = '';
    
    // Data
    public $services;
    public $bookingStatuses = ['pending', 'confirmed', 'in-progress', 'completed', 'cancelled', 'no-show'];
    
    // Stats
    public $stats = [];

    public function mount()
    {
        $this->services = Service::where('visibility', true)->get();
        $this->loadStats();
    }

    public function loadStats()
    {
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();

        $this->stats = [
            'total_bookings' => Booking::count(),
            'today_bookings' => Booking::whereDate('booking_date', $today)->count(),
            'week_bookings' => Booking::where('created_at', '>=', $thisWeek)->count(),
            'month_bookings' => Booking::where('created_at', '>=', $thisMonth)->count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
            'completed_bookings' => Booking::where('status', 'completed')->count(),
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedDateFilter()
    {
        $this->resetPage();
    }

    public function updatedServiceFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function getBookingsProperty()
    {
        $query = Booking::query();

        // Apply search filters
        if ($this->search) {
            $query->where(function($q) {
                $q->where('customer_first_name', 'like', '%' . $this->search . '%')
                  ->orWhere('customer_last_name', 'like', '%' . $this->search . '%')
                  ->orWhere('customer_email', 'like', '%' . $this->search . '%')
                  ->orWhere('customer_phone', 'like', '%' . $this->search . '%')
                  ->orWhere('service_name', 'like', '%' . $this->search . '%');
            });
        }

        // Apply status filter
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        // Apply date filter
        if ($this->dateFilter) {
            switch ($this->dateFilter) {
                case 'today':
                    $query->whereDate('booking_date', Carbon::today());
                    break;
                case 'tomorrow':
                    $query->whereDate('booking_date', Carbon::tomorrow());
                    break;
                case 'this_week':
                    $query->whereBetween('booking_date', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]);
                    break;
                case 'next_week':
                    $query->whereBetween('booking_date', [
                        Carbon::now()->addWeek()->startOfWeek(),
                        Carbon::now()->addWeek()->endOfWeek()
                    ]);
                    break;
                case 'this_month':
                    $query->whereRaw("strftime('%m', booking_date) = ?", [Carbon::now()->format('m')])
                          ->whereRaw("strftime('%Y', booking_date) = ?", [Carbon::now()->format('Y')]);
                    break;
            }
        }

        // Apply service filter
        if ($this->serviceFilter) {
            $query->where('service_id', $this->serviceFilter);
        }

        // Apply sorting (map old field names to new ones)
        $sortField = $this->sortBy;
        if ($sortField === 'BookedAt') {
            $sortField = 'created_at';
        }
        
        $query->orderBy($sortField, $this->sortDirection);

        // Get paginated results
        $bookings = $query->paginate($this->perPage);

        // Add formatted fields for the view
        $bookings->getCollection()->transform(function ($booking) {
            // Add computed fields for compatibility
            $booking->CustomerName = $booking->customer_first_name . ' ' . $booking->customer_last_name;
            $booking->CustomerEmail = $booking->customer_email;
            $booking->CustomerPhone = $booking->customer_phone;
            $booking->ServiceName = $booking->service_name;
            $booking->ServicePrice = $booking->service_price;
            $booking->Status = $booking->status;
            
            // Safe date parsing with error handling
            try {
                // Handle potential data format issues
                $bookingDate = $booking->booking_date;
                $bookingTime = $booking->booking_time;
                
                // Clean the date - ensure it's just the date part
                if (strlen($bookingDate) > 10) {
                    $bookingDate = substr($bookingDate, 0, 10);
                }
                
                // Clean the time - ensure it's just the time part  
                if (strlen($bookingTime) > 8) {
                    $bookingTime = substr($bookingTime, -8);
                }
                
                $bookingDateTime = Carbon::parse($bookingDate . ' ' . $bookingTime);
                $booking->FormattedBookedAt = $bookingDateTime->format('M j, Y g:i A');
                $booking->RelativeBookedAt = $bookingDateTime->diffForHumans();
            } catch (\Exception $e) {
                // Fallback if date parsing fails
                $booking->FormattedBookedAt = 'Invalid date';
                $booking->RelativeBookedAt = 'Unknown';
            }
            
            $booking->BookedAt = $booking->created_at; // For compatibility
            
            return $booking;
        });

        return $bookings;
    }

    public function viewBooking($bookingId)
    {
        $this->selectedBooking = Booking::find($bookingId);

        if ($this->selectedBooking) {
            // Add computed fields for compatibility with the view
            $this->selectedBooking->CustomerName = $this->selectedBooking->customer_first_name . ' ' . $this->selectedBooking->customer_last_name;
            $this->selectedBooking->CustomerEmail = $this->selectedBooking->customer_email;
            $this->selectedBooking->CustomerPhone = $this->selectedBooking->customer_phone;
            $this->selectedBooking->ServiceName = $this->selectedBooking->service_name;
            $this->selectedBooking->ServicePrice = $this->selectedBooking->service_price;
            $this->selectedBooking->Status = $this->selectedBooking->status;
            
            $this->newStatus = $this->selectedBooking->status;
            $this->adminNotes = $this->selectedBooking->admin_notes ?? '';
            $this->showBookingModal = true;
        }
    }

    public function updateBookingStatus()
    {
        if (!$this->selectedBooking || !$this->newStatus) {
            return;
        }

        $booking = Booking::find($this->selectedBooking->id);
        if ($booking) {
            $booking->update([
                'status' => $this->newStatus,
                'admin_notes' => $this->adminNotes,
            ]);
        }

        // In a real application, you might send email notifications here
        $this->closeModal();
        $this->loadStats();
        session()->flash('message', 'Booking status updated successfully!');
    }

    public function deleteBooking($bookingId)
    {
        $booking = Booking::find($bookingId);
        if ($booking) {
            $booking->delete();
        }

        $this->loadStats();
        session()->flash('message', 'Booking deleted successfully!');
    }

    public function exportBookings()
    {
        // In a real application, you would generate and download a CSV/Excel file
        session()->flash('message', 'Export functionality would be implemented here!');
    }

    public function closeModal()
    {
        $this->showBookingModal = false;
        $this->selectedBooking = null;
        $this->newStatus = '';
        $this->adminNotes = '';
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->dateFilter = '';
        $this->serviceFilter = '';
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.manage-bookings', [
            'bookings' => $this->bookings
        ]);
    }
}