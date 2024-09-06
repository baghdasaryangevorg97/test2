<?php

namespace App\Repositories;

use App\Contracts\TaskInterface;
use App\Models\Task;
use Carbon\Carbon;
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
     * @return Task
     */
    public function update(array $data, int $id): Task
    {
        $task = Task::find($id);
        $task->update($data);

        return $task;
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

    /**
     * Get task Statistics By Status.
     *
     * @param int $id
     * @return array
     */
    public function getStatisticsByStatus(): array
    {
        return Task::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status')
            ->toArray();
    }

    /**
     * Get expired count of task.
     *
     * @return array
     */
    public function getTaskExpiredCount(): int
    {
        return Task::where('due_date', '<', Carbon::now())
            ->count();
    }

    /**
     * Get task total count.
     *
     * @return array
     */
    public function getTaskTotalCount(): int
    {
        return Task::count();
    }

    /**
     * Get task Statistics By Status.
     *
     * @param int $id
     * @return array
     */
    public function getUserStatisticsCountByStatus($id): array
    {
        return Task::where('user_id', $id)->select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status')
            ->toArray();
    }

    /**
     * Get user task count By Status.
     * @param int $id
     * @return int
     */
    public function getUserAverageTaskCompletedTime($id): int
    {
        return Task::where('user_id', $id)->where('status', 'completed')->whereNotNull('completed_at')->whereNotNull('started_at')
            ->select(\DB::raw('AVG(TIMESTAMPDIFF(MINUTE, started_at, completed_at)) as avg_completion_time'))
            ->value('avg_completion_time');
    }


}
