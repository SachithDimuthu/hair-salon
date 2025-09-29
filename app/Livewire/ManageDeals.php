<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Deal;
use App\Models\Service;
use Livewire\Attributes\Validate;

class ManageDeals extends Component
{
    use WithPagination;

    #[Validate('required|string|max:255')]
    public $dealName = '';
    
    #[Validate('nullable|string')]
    public $description = '';
    
    #[Validate('required|numeric|min:0|max:100')]
    public $discountPercentage = '';
    
    #[Validate('required|date')]
    public $startDate = '';
    
    #[Validate('required|date|after:start_date')]
    public $endDate = '';
    
    #[Validate('boolean')]
    public $isActive = true;
    
    #[Validate('nullable|string')]
    public $serviceId;

    #[Validate('nullable|string')]
    public $terms = '';
    
    #[Validate('nullable|integer|min:1')]
    public $maxUses = null;
    
    public $currentUses = 0;

    public $search = '';
    public $editingDealId = null;
    public $showModal = false;
    public $message = '';
    public $messageType = '';
    public $services = [];

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->services = Service::where('visibility', true)->get();
    }

    public function resetForm()
    {
        $this->reset(['dealName', 'description', 'discountPercentage', 'startDate', 'endDate', 'isActive', 'serviceId', 'editingDealId']);
        $this->showModal = false;
        $this->resetValidation();
    }

    public function createDeal()
    {
        $this->resetForm();
        $this->isActive = true;
        $this->showModal = true;
    }

    public function editDeal($dealId)
    {
        $deal = Deal::find($dealId); // Use find() which works with MongoDB _id
        if (!$deal) {
            $this->message = 'Deal not found!';
            $this->messageType = 'error';
            return;
        }
        
        $this->editingDealId = $dealId;
        $this->dealName = $deal->DealName;
        $this->description = $deal->Description;
        $this->discountPercentage = $deal->DiscountPercentage;
        $this->startDate = $deal->StartDate;
        $this->endDate = $deal->EndDate;
        $this->isActive = $deal->IsActive;
        $this->serviceId = $deal->ServiceID;
        $this->showModal = true;
    }

    public function saveDeal()
    {
        $this->validate();

        $data = [
            'DealName' => $this->dealName,
            'Description' => $this->description,
            'DiscountPercentage' => $this->discountPercentage,
            'StartDate' => $this->startDate,
            'EndDate' => $this->endDate,
            'IsActive' => $this->isActive,
            'ServiceID' => $this->serviceId,
        ];

        if ($this->editingDealId) {
            $deal = Deal::find($this->editingDealId);
            if ($deal) {
                $deal->update($data);
                $this->message = 'Deal updated successfully!';
            } else {
                $this->message = 'Deal not found!';
                $this->messageType = 'error';
                return;
            }
        } else {
            Deal::create($data);
            $this->message = 'Deal created successfully!';
        }

        $this->messageType = 'success';
        $this->resetForm();
    }

    public function deleteDeal($dealId)
    {
        $deal = Deal::find($dealId);
        if ($deal) {
            $deal->delete();
            $this->message = 'Deal deleted successfully!';
            $this->messageType = 'success';
        } else {
            $this->message = 'Deal not found!';
            $this->messageType = 'error';
        }
    }

    public function toggleStatus($dealId)
    {
        $deal = Deal::find($dealId);
        if ($deal) {
            $deal->update(['IsActive' => !$deal->IsActive]);
            
            $status = $deal->IsActive ? 'activated' : 'deactivated';
            $this->message = "Deal {$status} successfully!";
            $this->messageType = 'success';
        } else {
            $this->message = 'Deal not found!';
            $this->messageType = 'error';
        }
    }

    public function render()
    {
        $deals = Deal::with('service')
            ->where('DealName', 'like', '%' . $this->search . '%')
            ->orWhere('Description', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.manage-deals', compact('deals'));
    }
}
