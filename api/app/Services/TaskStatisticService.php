<?php

namespace App\Services;

use App\Contracts\TaskInterface;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use App\Notifications\TaskDeadlineNotification;
use Carbon\Carbon;

class TaskStatisticService
{
    protected TaskInterface $taskRepository;

    public function __construct(TaskInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Get all tasks for the current user.
     *
     * @return array
     */
    public function index()
    {
        $statusCounts = $this->taskRepository->getStatisticsByStatus();
        $expiredCount = $this->taskRepository->getTaskExpiredCount();
        $totalAmount = $this->taskRepository->getTaskTotalCount();

        return [
            'status_counts' => $statusCounts,
            'expired_count' => $expiredCount,
            'total_amount' => $totalAmount,
        ];
    }
}
