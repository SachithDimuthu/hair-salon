<?php

namespace App\Livewire;

use App\Models\Review;
use App\Models\Customer;
use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;

class CustomerReviews extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $selectedRating = '';
    public $selectedService = '';
    public $sortBy = 'created_at';
    public $sortOrder = 'desc';
    
    // Review form properties
    public $showReviewForm = false;
    public $editingReview = null;

    #[Validate('required|string|max:255')]
    public $customer_name = '';

    #[Validate('required|email|max:255')]
    public $customer_email = '';

    #[Validate('required|integer|min:1|max:5')]
    public $rating = 5;

    #[Validate('required|string|max:1000')]
    public $comment = '';

    #[Validate('nullable|exists:services,id')]
    public $service_id = '';

    #[Validate('nullable|string|max:255')]
    public $title = '';

    public $services = [];
    public $averageRating = 0;
    public $totalReviews = 0;
    public $ratingDistribution = [];

    public function mount()
    {
        $this->services = Service::where('is_active', true)->orderBy('name')->get();
        $this->calculateStats();
    }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function updatingSelectedRating()
    {
        $this->resetPage();
    }

    public function updatingSelectedService()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortOrder = $this->sortOrder === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortOrder = 'asc';
        }
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['searchTerm', 'selectedRating', 'selectedService']);
        $this->resetPage();
    }

    public function showAddReviewForm()
    {
        $this->resetReviewForm();
        $this->showReviewForm = true;
    }

    public function editReview($reviewId)
    {
        $review = Review::find($reviewId);
        if ($review) {
            $this->editingReview = $review->id;
            $this->customer_name = $review->customer_name;
            $this->customer_email = $review->customer_email;
            $this->rating = $review->rating;
            $this->comment = $review->comment;
            $this->service_id = $review->service_id;
            $this->title = $review->title;
            $this->showReviewForm = true;
        }
    }

    public function saveReview()
    {
        $this->validate();

        if ($this->editingReview) {
            // Update existing review
            $review = Review::find($this->editingReview);
            $review->update([
                'customer_name' => $this->customer_name,
                'customer_email' => $this->customer_email,
                'rating' => $this->rating,
                'comment' => $this->comment,
                'service_id' => $this->service_id ?: null,
                'title' => $this->title,
            ]);
            session()->flash('message', 'Review updated successfully!');
        } else {
            // Create new review
            Review::create([
                'customer_name' => $this->customer_name,
                'customer_email' => $this->customer_email,
                'rating' => $this->rating,
                'comment' => $this->comment,
                'service_id' => $this->service_id ?: null,
                'title' => $this->title,
                'is_approved' => true, // Auto-approve for demo
            ]);
            session()->flash('message', 'Review added successfully!');
        }

        $this->closeReviewForm();
        $this->calculateStats();
    }

    public function deleteReview($reviewId)
    {
        Review::find($reviewId)->delete();
        session()->flash('message', 'Review deleted successfully!');
        $this->calculateStats();
    }

    public function toggleApproval($reviewId)
    {
        $review = Review::find($reviewId);
        $review->update(['is_approved' => !$review->is_approved]);
        $status = $review->is_approved ? 'approved' : 'unapproved';
        session()->flash('message', "Review {$status} successfully!");
    }

    public function closeReviewForm()
    {
        $this->showReviewForm = false;
        $this->resetReviewForm();
    }

    public function resetReviewForm()
    {
        $this->reset([
            'editingReview',
            'customer_name',
            'customer_email',
            'rating',
            'comment',
            'service_id',
            'title'
        ]);
        $this->rating = 5;
    }

    public function calculateStats()
    {
        $reviews = Review::where('is_approved', true);
        
        $this->totalReviews = $reviews->count();
        $this->averageRating = $this->totalReviews > 0 ? round($reviews->avg('rating'), 1) : 0;
        
        // Calculate rating distribution
        $this->ratingDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $count = $reviews->where('rating', $i)->count();
            $this->ratingDistribution[$i] = [
                'count' => $count,
                'percentage' => $this->totalReviews > 0 ? round(($count / $this->totalReviews) * 100) : 0
            ];
        }
    }

    public function getReviewsProperty()
    {
        $query = Review::with('service')
            ->orderBy($this->sortBy, $this->sortOrder);

        // Apply search filter
        if ($this->searchTerm) {
            $query->where(function ($q) {
                $q->where('customer_name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('comment', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('title', 'like', '%' . $this->searchTerm . '%');
            });
        }

        // Apply rating filter
        if ($this->selectedRating) {
            $query->where('rating', $this->selectedRating);
        }

        // Apply service filter
        if ($this->selectedService) {
            $query->where('service_id', $this->selectedService);
        }

        return $query->paginate(10);
    }

    public function render()
    {
        return view('livewire.customer-reviews', [
            'reviews' => $this->reviews,
        ]);
    }
}
