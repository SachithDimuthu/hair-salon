<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class ServiceCatalog extends Component
{
    use WithPagination;

    #[Url(as: 'search')]
    public $searchTerm = '';

    #[Url(as: 'category')]
    public $selectedCategory = '';

    #[Url(as: 'sort')]
    public $sortBy = 'name';

    #[Url(as: 'order')]
    public $sortOrder = 'asc';

    public $priceRange = [0, 500];
    public $minDuration = '';
    public $maxDuration = '';
    public $showFilters = false;

    protected $queryString = [
        'searchTerm' => ['except' => ''],
        'selectedCategory' => ['except' => ''],
        'sortBy' => ['except' => 'name'],
        'sortOrder' => ['except' => 'asc'],
    ];

    public function mount()
    {
        $this->priceRange = [0, 500];
    }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['searchTerm', 'selectedCategory', 'minDuration', 'maxDuration']);
        $this->priceRange = [0, 500];
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

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    public function getServicesProperty()
    {
        $query = Service::with(['category', 'staff'])
            ->where('is_active', true);

        // Apply search filter
        if ($this->searchTerm) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $this->searchTerm . '%');
            });
        }

        // Apply category filter
        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        // Apply price range filter
        if ($this->priceRange[0] > 0 || $this->priceRange[1] < 500) {
            $query->whereBetween('base_price', [$this->priceRange[0], $this->priceRange[1]]);
        }

        // Apply duration filters
        if ($this->minDuration) {
            $query->where('duration_minutes', '>=', $this->minDuration);
        }
        if ($this->maxDuration) {
            $query->where('duration_minutes', '<=', $this->maxDuration);
        }

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortOrder);

        return $query->paginate(12);
    }

    public function getCategoriesProperty()
    {
        return Category::where('type', 'service')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('livewire.service-catalog', [
            'services' => $this->services,
            'categories' => $this->categories,
        ]);
    }
}
