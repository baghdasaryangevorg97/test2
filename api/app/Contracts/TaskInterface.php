<?php

namespace App\Contracts;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskInterface
{
    /**
     * Get all tasks for the authenticated user.
     *
     * @return Collection
     */
    public function getUserAllTasks(): Collection;

    /**
     * Create a new task.
     *
     * @param array $data
     * @return Task
     */
    public function create(array $data): Task;

    /**
     * Get a task by its ID.
     *
     * @param int $id
     * @return Task
     */
    public function getTaskById(int $id): Task;

    /**
     * Update a task by its ID.
     *
     * @param array $data
     * @param int $id
     * @return Task
     */
    public function update(array $data, int $id): Task;

    /**
     * Remove a task by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function removeTaskById(int $id): bool;

    /**
     * Get task Statistics By Status.
     *
     * @return array
     */
    public function getStatisticsByStatus(): array;

    /**
     * Get expired count of task.
     *
     * @return array
     */
    public function getTaskExpiredCount(): int;

    /**
     * Get task total count.
     *
     * @return array
     */
    public function getTaskTotalCount(): int;

     /**
     * Get user task count By Status.
     * @param int $id
     * @return array
     */
    public function getUserStatisticsCountByStatus($id): array;

    /**
     * Get user task count By Status.
     * @param int $id
     * @return int
     */
    public function getUserAverageTaskCompletedTime($id): int;

}
