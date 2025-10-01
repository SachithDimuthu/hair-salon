<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use Illuminate\Support\Str;

class GlobalSearch extends Component
{
    public $query = '';
    public $showResults = false;
    public $results = [];

    public function updatedQuery()
    {
        if (strlen($this->query) >= 2) {
            $this->performSearch();
            $this->showResults = true;
        } else {
            $this->showResults = false;
            $this->results = [];
        }
    }

    public function performSearch()
    {
        $this->results = [];

        if (strlen($this->query) < 2) {
            return;
        }

        // Search Services
        $services = Service::where('visibility', true)
            ->where(function($query) {
                $query->where('name', 'like', '%' . $this->query . '%')
                      ->orWhere('description', 'like', '%' . $this->query . '%')
                      ->orWhere('category', 'like', '%' . $this->query . '%');
            })
            ->take(5)
            ->get();

        foreach ($services as $service) {
            $this->results[] = [
                'type' => 'service',
                'title' => $service->name,
                'description' => Str::limit($service->description, 80),
                'category' => $service->category,
                'price' => $service->base_price,
                'url' => route('services') . '#service-' . $service->_id,
                'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'
            ];
        }

        // Add page results
        $pages = [
            [
                'type' => 'page',
                'title' => 'Book Service',
                'description' => 'Schedule your salon appointment online',
                'url' => route('book-service'),
                'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'
            ],
            [
                'type' => 'page', 
                'title' => 'About Us',
                'description' => 'Learn more about Luxe Hair Studio',
                'url' => route('about'),
                'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
            ],
            [
                'type' => 'page',
                'title' => 'Contact Us', 
                'description' => 'Get in touch with our salon',
                'url' => route('contact'),
                'icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'
            ]
        ];

        foreach ($pages as $page) {
            if (Str::contains(strtolower($page['title']), strtolower($this->query)) || 
                Str::contains(strtolower($page['description']), strtolower($this->query))) {
                $this->results[] = $page;
            }
        }

        // Limit total results
        $this->results = array_slice($this->results, 0, 8);
    }

    public function clearSearch()
    {
        $this->query = '';
        $this->showResults = false;
        $this->results = [];
    }

    public function selectResult($url)
    {
        $this->clearSearch();
        return redirect($url);
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}