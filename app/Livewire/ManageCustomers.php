<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Customer;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;

class ManageCustomers extends Component
{
    use WithPagination;

    #[Validate('required|string|max:255')]
    public $customerName = '';
    
    #[Validate('required|email|unique:customers,Email')]
    public $email = '';
    
    #[Validate('required|string|min:8')]
    public $password = '';
    
    #[Validate('nullable|string|max:20')]
    public $phoneNumber = '';

    public $search = '';
    public $editingCustomerId = null;
    public $showModal = false;
    public $message = '';
    public $messageType = '';

    protected $paginationTheme = 'tailwind';

    public function resetForm()
    {
        $this->reset(['customerName', 'email', 'password', 'phoneNumber', 'editingCustomerId']);
        $this->showModal = false;
        $this->resetValidation();
    }

    public function createCustomer()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function editCustomer($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $this->editingCustomerId = $customerId;
        $this->customerName = $customer->CustomerName;
        $this->email = $customer->Email;
        $this->phoneNumber = $customer->PhoneNumber;
        $this->password = ''; // Don't populate password for security
        $this->showModal = true;
    }

    public function saveCustomer()
    {
        // Modify validation rules for editing
        $rules = [
            'customerName' => 'required|string|max:255',
            'phoneNumber' => 'nullable|string|max:20',
        ];

        if ($this->editingCustomerId) {
            $rules['email'] = 'required|email|unique:customers,Email,' . $this->editingCustomerId . ',CustomerID';
            $rules['password'] = 'nullable|string|min:8';
        } else {
            $rules['email'] = 'required|email|unique:customers,Email';
            $rules['password'] = 'required|string|min:8';
        }

        $this->validate($rules);

        $data = [
            'CustomerName' => $this->customerName,
            'Email' => $this->email,
            'PhoneNumber' => $this->phoneNumber,
        ];

        if ($this->password) {
            $data['Password'] = Hash::make($this->password);
        }

        if ($this->editingCustomerId) {
            Customer::where('CustomerID', $this->editingCustomerId)->update($data);
            $this->message = 'Customer updated successfully!';
        } else {
            Customer::create($data);
            $this->message = 'Customer created successfully!';
        }

        $this->messageType = 'success';
        $this->resetForm();
    }

    public function deleteCustomer($customerId)
    {
        Customer::findOrFail($customerId)->delete();
        $this->message = 'Customer deleted successfully!';
        $this->messageType = 'success';
    }

    public function render()
    {
        $customers = Customer::where('CustomerName', 'like', '%' . $this->search . '%')
            ->orWhere('Email', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.manage-customers', compact('customers'));
    }
}
