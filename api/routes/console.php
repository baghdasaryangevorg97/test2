<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Task;
use Carbon\Carbon;


Schedule::command('tasks:send-reminders')->everyMinute();

Artisan::command('tasks:send-reminders', function () {
    $tasks = Task::where('due_date', '>=', Carbon::now()->subHour())
                 ->where('due_date', '<=', Carbon::now())
                 ->get();

    info("Tasks", [$tasks]);

    foreach ($tasks as $task) {
        $task->sendReminder();
    }
})->describe('Send task deadline reminders');
