<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use App\Models\Task;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Show extends Component
{
    public Customer $customer;

    // --- یادداشت‌ها ---
    public string $newNote = '';

    // --- تسک‌ها ---
    public string $newTaskTitle = '';
    public ?string $newTaskDueDate = null;

    // --- مودال ویرایش ---
    public bool $showEditModal = false;
    public $name = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $status = 'lead';

    // --- مودال حذف ---
    public bool $showDeleteConfirm = false;

    public function mount(Customer $customer)
    {
        $this->customer = $customer;
    }

    // ================= یادداشت =================
    public function addNote()
    {
        $this->validate([
            'newNote' => 'required|string|max:2000',
        ]);

        $this->customer->notes()->create([
            'body' => $this->newNote,
        ]);

        $this->reset('newNote');
    }

    // ================= تسک =================
    public function addTask()
    {
        $this->validate([
            'newTaskTitle'   => 'required|string|max:255',
            'newTaskDueDate' => 'nullable|date',
        ]);

        $this->customer->tasks()->create([
            'title'    => $this->newTaskTitle,
            'due_date' => $this->newTaskDueDate,
        ]);

        $this->reset(['newTaskTitle', 'newTaskDueDate']);
    }

    public function toggleTask(int $taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->update([
            'status' => $task->status === 'done' ? 'pending' : 'done',
        ]);
    }

    // ================= ویرایش مشتری =================
    public function openEditModal()
    {
        $this->name    = $this->customer->name;
        $this->email   = $this->customer->email;
        $this->phone   = $this->customer->phone;
        $this->address = $this->customer->address;
        $this->status  = $this->customer->status;

        $this->resetValidation();
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetValidation();
    }

    public function updateCustomer()
    {
        $this->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'status'  => 'required|in:lead,customer',
        ]);

        $this->customer->update([
            'name'    => $this->name,
            'email'   => $this->email,
            'phone'   => $this->phone,
            'address' => $this->address,
            'status'  => $this->status,
        ]);

        $this->showEditModal = false;
        session()->flash('message', 'اطلاعات مشتری با موفقیت ذخیره شد.');
    }

    // ================= حذف مشتری =================
    public function confirmDelete()
    {
        $this->showDeleteConfirm = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteConfirm = false;
    }

    public function deleteCustomer()
    {
        $this->customer->delete();

        session()->flash('message', 'مشتری با موفقیت حذف شد.');

        return $this->redirect(route('customers.index'), navigate: true);
    }

    public function render()
    {
        $notes = $this->customer->notes()->latest()->get();
        $tasks = $this->customer->tasks()->orderBy('due_date')->get();

        return view('livewire.customers.show', [
            'notes'        => $notes,
            'tasks'        => $tasks,
            'pendingTasks' => $tasks->where('status', 'pending')->count(),
            'lastActivity' => $notes->first()?->created_at ?? $this->customer->created_at,
        ]);
    }
}
