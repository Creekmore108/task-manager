<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Models\Project;
use Livewire\Attributes\Rule;

class TaskManager extends Component
{
    public $tasks;
    public $projects;
    public $selectedProjectId = null;

    #[Rule('required|min:3')]
    public $name;
    public $taskId;
    public $editing = false;
    #[Rule('required|min:1|max:10')]
    public $priority;

    public function mount()
    {
        $this->projects = Project::all();
        $this->loadTasks();
    }

    public function loadTasks()
    {
        $this->tasks = Task::when($this->selectedProjectId, function ($query) {
                $query->where('project_id', $this->selectedProjectId);
            })->orderBy('priority')->get();
    }

    public function addTask()
    {
        $this->validate();

        Task::create([
            'name' => $this->name,
            'priority' =>  1,
            'project_id' => $this->selectedProjectId ?? $this->projects->first()->id,
        ]);

        $this->reset(['name', 'priority', 'taskId']);
        $this->loadTasks();
    }

    public function editTask($id)
    {
        $task = Task::find($id);
        $this->name = $task->name;
        $this->taskId = $task->id;
        $this->priority = $task->priority;
        $this->editing = true;
    }

    public function updateTask()
    {
        $this->validate();

        Task::find($this->taskId)->update([
            'name' => $this->name,
            'priority' => $this->priority
        ]);

        $this->reset(['name', 'taskId','priority', 'editing']);
        $this->loadTasks();
    }

    public function deleteTask($id)
    {
        Task::find($id)->delete();
        $this->loadTasks();
    }

    public function updateTaskOrder($tasks)
    {
        foreach ($tasks as $index => $task) {
            Task::find($task['value'])->update(['priority' => $index + 1]);
        }
        $this->loadTasks();
    }

    public function render()
    {
        return view('livewire.task-manager');
    }

    public function updatedSelectedProjectId(){
        $this->loadTasks();
    }
}
