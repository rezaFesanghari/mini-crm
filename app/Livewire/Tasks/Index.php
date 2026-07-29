<?php

namespace App\Livewire\Tasks;

use App\Models\Customer;
use App\Models\Task;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    public string $filter = 'pending'; // all | pending | done

    public bool $showCreateModal = false;
    public $customer_id = '';
    public $title = '';
    public $due_date = '';

    protected function rules()
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'title'       => 'required|string|max:255',
            'due_date'    => 'nullable|date',
        ];
    }

    public function setFilter(string $filter)
    {
        $this->filter = $filter;
    }

    public function openCreateModal()
    {
        $this->resetValidation();
        $this->reset(['customer_id', 'title', 'due_date']);
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

        Task::create([
            'customer_id' => $this->customer_id,
            'title'       => $this->title,
            'due_date'    => $this->due_date ?: null,
        ]);

        $this->closeCreateModal();
        session()->flash('message', 'تسک با موفقیت ثبت شد.');
    }

    public function toggleTask(int $taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->update([
            'status' => $task->status === 'done' ? 'pending' : 'done',
        ]);
    }

    public function render()
    {
        $query = Task::with('customer')->orderBy('due_date');

        if ($this->filter !== 'all') {
            $query->where('status', $this->filter);
        }

        $tasks = $query->get();

        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        $grouped = [
            'overdue' => $tasks->filter(fn ($t) => $t->due_date && Carbon::parse($t->due_date)->lt($today) && $t->status === 'pending'),
            'today'   => $tasks->filter(fn ($t) => $t->due_date && Carbon::parse($t->due_date)->isSameDay($today)),
            'tomorrow'=> $tasks->filter(fn ($t) => $t->due_date && Carbon::parse($t->due_date)->isSameDay($tomorrow)),
            'later'   => $tasks->filter(fn ($t) => !$t->due_date || Carbon::parse($t->due_date)->gt($tomorrow)),
        ];

        return view('livewire.tasks.index', [
            'grouped'      => $grouped,
            'customers'    => Customer::orderBy('name')->get(),
            'pendingCount' => Task::where('status', 'pending')->count(),
        ]);
    }
}
