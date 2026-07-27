<?php

namespace App\Livewire\Deals;

use App\Models\Customer;
use App\Models\Deal;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    public bool $showCreateModal = false;

    public $customer_id = '';
    public $title = '';
    public $value = '';
    public $stage = 'new';

    protected $stages = ['new', 'contacted', 'negotiation', 'won', 'lost'];

    protected function rules()
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'title'       => 'required|string|max:255',
            'value'       => 'nullable|numeric|min:0',
        ];
    }

    public function openCreateModal()
    {
        $this->resetValidation();
        $this->reset(['customer_id', 'title', 'value']);
        $this->stage = 'new';
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        Deal::create([
            'customer_id' => $this->customer_id,
            'title'       => $this->title,
            'value'       => $this->value ?: 0,
            'stage'       => 'new',
        ]);

        $this->closeCreateModal();
        session()->flash('message', 'معامله با موفقیت ثبت شد.');
    }

    // این متد از جاوااسکریپت (Sortable.js) صدا زده میشه
    public function moveDeal(int $dealId, string $newStage)
    {
        if (!in_array($newStage, $this->stages)) {
            return;
        }

        Deal::where('id', $dealId)->update(['stage' => $newStage]);
    }

    public function render()
    {
        $deals = Deal::with('customer')->latest()->get()->groupBy('stage');

        return view('livewire.deals.index', [
            'dealsByStage' => $deals,
            'customers'    => Customer::orderBy('name')->get(),
            'stageLabels'  => [
                'new'         => 'جدید',
                'contacted'   => 'تماس گرفته شده',
                'negotiation' => 'مذاکره',
                'won'         => 'برنده',
                'lost'        => 'باخته',
            ],
        ]);
    }
}
