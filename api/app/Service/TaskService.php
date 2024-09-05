<?php

namespace App\Services;

use App\Contracts\TaskInterface;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    protected TaskInterface $taskRepository;

    public function __construct(TaskInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Get all tasks for the current user.
     *
     * @return Collection
     */
    public function getUserAllTasks(): Collection
    {
        return $this->taskRepository->getUserAllTasks();
    }

    /**
     * Create a new task.
     *
     * @param array $data
     * @return Task
     */
    public function create(array $data): Task
    {
        return $this->taskRepository->create($data);
    }

    /**
     * Get task by ID.
     *
     * @param int $id
     * @return Task|null
     */
    public function getTaskById(int $id): ?Task
    {
        return $this->taskRepository->getTaskById($id);
    }

    /**
     * Update task by ID.
     *
     * @param array $data
     * @param int $id
     * @return Task|null
     */
    public function update(array $data, int $id): ?Task
    {
        return $this->taskRepository->update($data, $id);
    }

    /**
     * Delete task by ID.
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        return $this->taskRepository->removeTaskById($id);
    }
}
