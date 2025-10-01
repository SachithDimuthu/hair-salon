<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Service;
use App\Models\Customer;
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
            'total_bookings' => DB::table('customer_service')->count(),
            'today_bookings' => DB::table('customer_service')
                ->whereDate('BookedAt', $today)
                ->count(),
            'week_bookings' => DB::table('customer_service')
                ->where('BookedAt', '>=', $thisWeek)
                ->count(),
            'month_bookings' => DB::table('customer_service')
                ->where('BookedAt', '>=', $thisMonth)
                ->count(),
            'pending_bookings' => DB::table('customer_service')
                ->where('Status', 'pending')
                ->count(),
            'confirmed_bookings' => DB::table('customer_service')
                ->where('Status', 'confirmed')
                ->count(),
            'completed_bookings' => DB::table('customer_service')
                ->where('Status', 'completed')
                ->count(),
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
        $query = DB::table('customer_service')
            ->join('customers', 'customer_service.CustomerID', '=', 'customers.CustomerID')
            ->select(
                'customer_service.*',
                'customers.CustomerName',
                'customers.Email as CustomerEmail',
                'customers.PhoneNumber as CustomerPhone'
            );

        // Apply filters
        if ($this->search) {
            $query->where(function($q) {
                $q->where('customers.CustomerName', 'like', '%' . $this->search . '%')
                  ->orWhere('customers.Email', 'like', '%' . $this->search . '%')
                  ->orWhere('customers.PhoneNumber', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('customer_service.Status', $this->statusFilter);
        }

        if ($this->dateFilter) {
            switch ($this->dateFilter) {
                case 'today':
                    $query->whereDate('customer_service.BookedAt', Carbon::today());
                    break;
                case 'tomorrow':
                    $query->whereDate('customer_service.BookedAt', Carbon::tomorrow());
                    break;
                case 'this_week':
                    $query->whereBetween('customer_service.BookedAt', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]);
                    break;
                case 'next_week':
                    $query->whereBetween('customer_service.BookedAt', [
                        Carbon::now()->addWeek()->startOfWeek(),
                        Carbon::now()->addWeek()->endOfWeek()
                    ]);
                    break;
                case 'this_month':
                    $query->whereMonth('customer_service.BookedAt', Carbon::now()->month)
                          ->whereYear('customer_service.BookedAt', Carbon::now()->year);
                    break;
            }
        }

        if ($this->serviceFilter) {
            $query->where('customer_service.ServiceID', $this->serviceFilter);
        }

        // Apply sorting
        $query->orderBy('customer_service.' . $this->sortBy, $this->sortDirection);

        // Get paginated results
        $bookings = $query->paginate($this->perPage);

        // Enhance with service information
        $bookings->getCollection()->transform(function ($booking) {
            $service = Service::find($booking->ServiceID);
            $booking->ServiceName = $service ? $service->name : 'Unknown Service';
            $booking->ServicePrice = $service ? $service->base_price : 0;
            $booking->ServiceCategory = $service ? $service->category : 'Unknown';
            
            // Format dates
            $booking->FormattedBookedAt = Carbon::parse($booking->BookedAt)->format('M j, Y g:i A');
            $booking->RelativeBookedAt = Carbon::parse($booking->BookedAt)->diffForHumans();
            
            return $booking;
        });

        return $bookings;
    }

    public function viewBooking($bookingId, $customerId)
    {
        $this->selectedBooking = DB::table('customer_service')
            ->join('customers', 'customer_service.CustomerID', '=', 'customers.CustomerID')
            ->where('customer_service.CustomerID', $customerId)
            ->where('customer_service.ServiceID', $bookingId)
            ->select(
                'customer_service.*',
                'customers.CustomerName',
                'customers.Email as CustomerEmail',
                'customers.PhoneNumber as CustomerPhone'
            )
            ->first();

        if ($this->selectedBooking) {
            $service = Service::find($this->selectedBooking->ServiceID);
            $this->selectedBooking->ServiceName = $service ? $service->name : 'Unknown Service';
            $this->selectedBooking->ServicePrice = $service ? $service->base_price : 0;
            $this->selectedBooking->ServiceCategory = $service ? $service->category : 'Unknown';
            
            $this->newStatus = $this->selectedBooking->Status;
            $this->showBookingModal = true;
        }
    }

    public function updateBookingStatus()
    {
        if (!$this->selectedBooking || !$this->newStatus) {
            return;
        }

        DB::table('customer_service')
            ->where('CustomerID', $this->selectedBooking->CustomerID)
            ->where('ServiceID', $this->selectedBooking->ServiceID)
            ->update([
                'Status' => $this->newStatus,
                'AdminNotes' => $this->adminNotes,
                'updated_at' => now()
            ]);

        // In a real application, you might send email notifications here
        $this->closeModal();
        $this->loadStats();
        session()->flash('message', 'Booking status updated successfully!');
    }

    public function deleteBooking($customerId, $serviceId)
    {
        DB::table('customer_service')
            ->where('CustomerID', $customerId)
            ->where('ServiceID', $serviceId)
            ->delete();

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