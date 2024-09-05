<?php

namespace App\Repositories;

use App\Contracts\TaskInterface;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskInterface
{
    /**
     * Get all tasks for the authenticated user.
     *
     * @return Collection
     */
    public function getUserAllTasks(): Collection
    {
        return Task::where('user_id', auth()->user()->id)->get();
    }

    /**
     * Create a new task.
     *
     * @param array $data
     * @return Task
     */
    public function create(array $data): Task
    {
        return Task::create($data);
    }

    /**
     * Get a task by its ID.
     *
     * @param int $id
     * @return Task
     */
    public function getTaskById(int $id): Task
    {
        return Task::findOrFail($id);
    }

    /**
     * Update a task by its ID.
     *
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update(array $data, int $id): bool
    {
        return Task::where('id', $id)->update($data) > 0;
    }

    /**
     * Remove a task by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function removeTaskById(int $id): bool
    {
        return Task::where('id', $id)->where('user_id', auth()->id())->delete() > 0;
    }
}
