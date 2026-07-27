<?php

namespace App\Livewire\Companies;

use App\Models\Company;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

#[Layout('layouts.app')]
class Index extends Component
{
    public bool $showCreateModal = false;
    public ?int $editingCompanyId = null;

    public $name = '';
    public $website = '';
    public $phone = '';
    public $address = '';

    public string $search = '';

    public ?int $companyIdToDelete = null;

    protected function rules()
    {
        return [
            'name'    => 'required|string|max:255',
            'website' => 'nullable|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ];
    }

    public function openCreateModal()
    {
        $this->resetValidation();
        $this->reset(['name', 'website', 'phone', 'address', 'editingCompanyId']);
        $this->showCreateModal = true;
    }

    public function openEditModal(int $companyId)
    {
        $company = Company::findOrFail($companyId);

        $this->editingCompanyId = $company->id;
        $this->name    = $company->name;
        $this->website = $company->website;
        $this->phone   = $company->phone;
        $this->address = $company->address;

        $this->resetValidation();
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetValidation();
        $this->reset(['name', 'website', 'phone', 'address', 'editingCompanyId']);
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name'    => $this->name,
            'website' => $this->website,
            'phone'   => $this->phone,
            'address' => $this->address,
        ];

        if ($this->editingCompanyId) {
            Company::whereKey($this->editingCompanyId)->update($data);
            $message = 'شرکت با موفقیت ویرایش شد.';
        } else {
            Company::create($data);
            $message = 'شرکت با موفقیت ثبت شد.';
        }

        $this->closeCreateModal();
        session()->flash('message', $message);
    }

    public function confirmDelete(int $companyId)
    {
        $this->companyIdToDelete = $companyId;
    }

    public function cancelDelete()
    {
        $this->companyIdToDelete = null;
    }

    public function deleteCompany()
    {
        Company::where('id', $this->companyIdToDelete)->delete();
        $this->companyIdToDelete = null;
        session()->flash('message', 'شرکت با موفقیت حذف شد.');
    }

    public function render()
    {
        $query = Company::withCount('customers')->latest();

        if (trim($this->search) !== '') {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        return view('livewire.companies.index', [
            'companies'   => $query->get(),
            'totalCount'  => Company::count(),
        ]);
    }
}
