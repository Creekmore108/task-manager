<div class="p-4">
    <select wire:model.live="selectedProjectId" class="border rounded p-2 mb-4">
        <option value="">All Projects</option>
        @foreach($projects as $project)
            <option value="{{ $project->id }}">{{ $project->name }}</option>
        @endforeach
    </select>
    <div class="mb-4">
        <input type="text" wire:model="name" placeholder="Task Name" required class="border rounded p-2">
        <input type="text" wire:model="priority" placeholder="Priority" required class="border rounded p-2">
        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
        @error('priority') <span class="text-red-500">{{ $message }}</span> @enderror
        @if($editing)
            <button wire:click="updateTask" class="bg-blue-500 text-white rounded p-2">Update</button>
            <button wire:click="$set('editing', false)" class="bg-gray-300 rounded p-2">Cancel</button>
        @else
            <button wire:click="addTask" class="bg-green-500 text-white rounded p-2">Add Task</button>
        @endif
    </div>

    <ul x-sort class="space-y-2">
        @foreach($tasks as $task)
            <li x-sort.item wire:task="{{ $task->id }}" wire:key="task-{{ $task->id }}" class="border rounded p-2 flex items-center justify-between" wire:sortable.handle>
                <span >
                    {{ $task->name }} (Priority: {{ $task->priority }})</span>
                <div>
                    <button wire:click="editTask({{ $task->id }})" class="bg-yellow-500 text-white rounded p-1">Edit</button>
                    <button wire:click="deleteTask({{ $task->id }})" class="bg-red-500 text-white rounded p-1">Delete</button>
                </div>
            </li>
        @endforeach
    </ul>
    {{-- <ul wire:sortable="updateTaskOrder" class="space-y-2">
        @foreach($tasks as $task)
            <li wire:sortable.item="{{ $task->id }}" wire:key="task-{{ $task->id }}" class="border rounded p-2 flex items-center justify-between" wire:sortable.handle>
                <span >{{ $task->name }} (Priority: {{ $task->priority }})</span>
                <div>
                    <button wire:click="editTask({{ $task->id }})" class="bg-yellow-500 text-white rounded p-1">Edit</button>
                    <button wire:click="deleteTask({{ $task->id }})" class="bg-red-500 text-white rounded p-1">Delete</button>
                </div>
            </li>
        @endforeach
    </ul> --}}
</div>

