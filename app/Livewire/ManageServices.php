<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Service;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ManageServices extends Component
{
    use WithPagination, WithFileUploads;

    #[Validate('required|string|max:255')]
    public $serviceName = '';
    
    #[Validate('nullable|string')]
    public $description = '';
    
    #[Validate('required|numeric|min:0')]
    public $price = '';
    
    #[Validate('boolean')]
    public $visibility = true;
    
    #[Validate('nullable|image|max:2048')]
    public $servicePhoto;

    #[Validate('required|integer|min:15')]
    public $duration = 60; // Duration in minutes
    
    #[Validate('required|string|max:100')]
    public $category = '';

    public $search = '';
    public $editingServiceId = null;
    public $showModal = false;
    public $message = '';
    public $messageType = '';

    protected $paginationTheme = 'tailwind';

    public function resetForm()
    {
        $this->reset(['serviceName', 'description', 'price', 'visibility', 'servicePhoto', 'duration', 'category', 'editingServiceId']);
        $this->showModal = false;
        $this->resetValidation();
    }

    public function createService()
    {
        $this->resetForm();
        $this->visibility = true;
        $this->showModal = true;
    }

    public function editService($serviceId)
    {
        try {
            $service = Service::find($serviceId);
            if (!$service) {
                $this->message = 'Service not found!';
                $this->messageType = 'error';
                return;
            }
            
            $this->editingServiceId = $serviceId;
            $this->serviceName = $service->name;
            $this->description = $service->description;
            $this->price = (float)$service->base_price;
            $this->visibility = $service->visibility;
            
            // Handle durations array structure
            if (is_array($service->durations) && count($service->durations) > 0) {
                $firstDuration = $service->durations[0];
                if (is_array($firstDuration) && isset($firstDuration['minutes'])) {
                    $this->duration = $firstDuration['minutes'];
                    $this->price = $firstDuration['price'] ?? $this->price;
                } else {
                    $this->duration = is_numeric($firstDuration) ? $firstDuration : 60;
                }
            } else {
                $this->duration = 60;
            }
            
            $this->category = $service->category ?? '';
            $this->servicePhoto = null; // Don't populate file for security
            $this->showModal = true;
        } catch (\Exception $e) {
            $this->message = 'Error loading service: ' . $e->getMessage();
            $this->messageType = 'error';
        }
    }

    public function saveService()
    {
        $this->validate();

        $data = [
            'name' => $this->serviceName,
            'slug' => Str::slug($this->serviceName),
            'description' => $this->description,
            'base_price' => $this->price,
            'visibility' => $this->visibility,
            'durations' => [[
                'variant' => 'Standard',
                'minutes' => $this->duration,
                'price' => $this->price
            ]],
            'category' => $this->category,
            'active' => true,
        ];

        // Handle file upload
        if ($this->servicePhoto) {
            $path = $this->servicePhoto->store('service-photos', 'public');
            $data['image'] = $path;
        }

        try {
            // Ensure unique slug
            $baseSlug = $data['slug'];
            $counter = 1;
            while (Service::where('slug', $data['slug'])->where('_id', '!=', $this->editingServiceId)->exists()) {
                $data['slug'] = $baseSlug . '-' . $counter;
                $counter++;
            }

            if ($this->editingServiceId) {
                $service = Service::find($this->editingServiceId);
                if ($service) {
                    $service->update($data);
                    $this->message = 'Service updated successfully!';
                    $this->messageType = 'success';
                } else {
                    $this->message = 'Service not found!';
                    $this->messageType = 'error';
                    return;
                }
            } else {
                Service::create($data);
                $this->message = 'Service created successfully!';
                $this->messageType = 'success';
            }

            $this->resetForm();
        } catch (\Exception $e) {
            $this->message = 'Error saving service: ' . $e->getMessage();
            $this->messageType = 'error';
        }
    }

    public function deleteService($serviceId)
    {
        try {
            $service = Service::find($serviceId);
            if (!$service) {
                $this->message = 'Service not found!';
                $this->messageType = 'error';
                return;
            }
            
            // Delete photo file if exists
            if ($service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }

            $service->delete();
            $this->message = 'Service deleted successfully!';
            $this->messageType = 'success';
        } catch (\Exception $e) {
            $this->message = 'Error deleting service: ' . $e->getMessage();
            $this->messageType = 'error';
        }
    }

    public function toggleVisibility($serviceId)
    {
        try {
            $service = Service::find($serviceId);
            if (!$service) {
                $this->message = 'Service not found!';
                $this->messageType = 'error';
                return;
            }
            
            $service->update(['visibility' => !$service->visibility]);
            
            $status = $service->visibility ? 'visible' : 'hidden';
            $this->message = "Service is now {$status}!";
            $this->messageType = 'success';
        } catch (\Exception $e) {
            $this->message = 'Error updating service visibility: ' . $e->getMessage();
            $this->messageType = 'error';
        }
    }

    public function render()
    {
        $services = Service::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('category', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.manage-services', compact('services'));
    }
}