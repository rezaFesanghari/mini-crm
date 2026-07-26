<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    public bool $showCreateModal = false;
    public ?int $editingCustomerId = null;

    public $name = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $status = 'lead';

    public string $filter = 'all';
    public string $search = '';

    public ?int $customerIdToDelete = null;

    protected function rules()
    {
        return [
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'status'  => 'required|in:lead,customer',
        ];
    }

    // --- باز کردن مودال برای افزودن ---
    public function openCreateModal()
    {
        $this->resetValidation();
        $this->reset(['name', 'email', 'phone', 'address', 'editingCustomerId']);
        $this->status = 'lead';
        $this->showCreateModal = true;
    }

    // --- باز کردن مودال برای ویرایش، پر از داده‌ی موجود ---
    public function openEditModal(int $customerId)
    {
        $customer = Customer::findOrFail($customerId);

        $this->editingCustomerId = $customer->id;
        $this->name    = $customer->name;
        $this->email   = $customer->email;
        $this->phone   = $customer->phone;
        $this->address = $customer->address;
        $this->status  = $customer->status;

        $this->resetValidation();
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetValidation();
        $this->reset(['name', 'email', 'phone', 'address', 'editingCustomerId']);
        $this->status = 'lead';
    }

    // --- یک متد save برای هر دو حالت ---
    public function save()
    {
        $this->validate();

        $data = [
            'name'    => $this->name,
            'email'   => $this->email,
            'phone'   => $this->phone,
            'address' => $this->address,
            'status'  => $this->status,
        ];

        if ($this->editingCustomerId) {
            Customer::whereKey($this->editingCustomerId)->update($data);
            $message = 'مشتری با موفقیت ویرایش شد.';
        } else {
            Customer::create($data);
            $message = 'مشتری با موفقیت ثبت شد.';
        }

        $this->closeCreateModal();
        session()->flash('message', $message);
    }

    public function setFilter(string $filter)
    {
        $this->filter = $filter;
    }

    public function confirmDelete(int $customerId)
    {
        $this->customerIdToDelete = $customerId;
    }

    public function cancelDelete()
    {
        $this->customerIdToDelete = null;
    }

    public function deleteCustomer()
    {
        Customer::where('id', $this->customerIdToDelete)->delete();
        $this->customerIdToDelete = null;
        session()->flash('message', 'مشتری با موفقیت حذف شد.');
    }

    public function render()
    {
        $query = Customer::query()->latest();

        if ($this->filter !== 'all') {
            $query->where('status', $this->filter);
        }

        if (trim($this->search) !== '') {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhereHas('company', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        return view('livewire.customers.index', [
            'customers'     => $query->get(),
            'totalCount'    => Customer::count(),
            'customerCount' => Customer::where('status', 'customer')->count(),
            'leadCount'     => Customer::where('status', 'lead')->count(),
        ]);
    }
}
