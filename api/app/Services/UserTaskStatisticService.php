<?php

namespace App\Services;

use App\Contracts\TaskInterface;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use App\Notifications\TaskDeadlineNotification;
use Carbon\Carbon;

class UserTaskStatisticService
{
    protected TaskInterface $taskRepository;

    public function __construct(TaskInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Get user task statistics.
     *
     * @return array
     */
    public function index($id)
    {
        $statusCounts = $this->taskRepository->getUserStatisticsCountByStatus($id);
        $averageTaskCompletedTime = $this->taskRepository->getUserAverageTaskCompletedTime($id);

        return [
            'status_counts' => $statusCounts,
            'average_tasks' => $averageTaskCompletedTime . " minute",
        ];
    }
}
