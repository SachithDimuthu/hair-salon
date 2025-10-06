<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Deal;
use App\Models\Service;
use Illuminate\Support\Collection;

class HomePage extends Component
{
    public $deals;
    public $popularServices;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        // Get active deals with their services
        $this->deals = Deal::with('service')
            ->where('IsActive', true)
            ->where('StartDate', '<=', now())
            ->where('EndDate', '>=', now())
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Get 6 most popular services (active and visible)
        $this->popularServices = Service::where('active', true)
            ->where('visibility', 'public')
            ->orderBy('price', 'desc')
            ->limit(6)
            ->get();
    }

    public function render()
    {
        return view('livewire.home-page');
    }
}
