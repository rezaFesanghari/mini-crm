<?php

namespace App\Livewire\Companies;

use App\Models\Company;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Show extends Component
{
    public Company $company;

    // مودال ویرایش شرکت
    public bool $showEditModal = false;
    public $name = '';
    public $website = '';
    public $phone = '';
    public $address = '';

    // مودال حذف
    public bool $showDeleteConfirm = false;

    public function mount(Company $company)
    {
        $this->company = $company;
    }

    public function openEditModal()
    {
        $this->name    = $this->company->name;
        $this->website = $this->company->website;
        $this->phone   = $this->company->phone;
        $this->address = $this->company->address;

        $this->resetValidation();
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetValidation();
    }

    public function updateCompany()
    {
        $this->validate([
            'name'    => 'required|string|max:255',
            'website' => 'nullable|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $this->company->update([
            'name'    => $this->name,
            'website' => $this->website,
            'phone'   => $this->phone,
            'address' => $this->address,
        ]);

        $this->showEditModal = false;
        session()->flash('message', 'اطلاعات شرکت با موفقیت ذخیره شد.');
    }

    public function confirmDelete()
    {
        $this->showDeleteConfirm = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteConfirm = false;
    }

    public function deleteCompany()
    {
        $this->company->delete();

        session()->flash('message', 'شرکت با موفقیت حذف شد.');

        return $this->redirect(route('companies.index'), navigate: true);
    }

    public function render()
    {
        $customers = $this->company->customers()->latest()->get();

        return view('livewire.companies.show', [
            'customers'     => $customers,
            'customerCount' => $customers->count(),
            'leadCount'     => $customers->where('status', 'lead')->count(),
            'activeCount'   => $customers->where('status', 'customer')->count(),
        ]);
    }
}
