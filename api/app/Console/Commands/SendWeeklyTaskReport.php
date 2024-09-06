<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendWeeklyTaskReport extends Command
{
    protected $signature = 'report:weekly-tasks';
    protected $description = 'Sended report in a last week';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $usersWithRecentTasks = User::with('tasks')->whereHas('tasks', function ($query) {
            $query->where('created_at', '>=', Carbon::now()->subDays(7));
        })->get();

        foreach ($usersWithRecentTasks as $user) {

       
            $tasksString = $user->tasks->map(function ($task) {
                return "ID: {$task['id']}, Title: {$task['title']}, Status: {$task['status']}";
            })->implode("\n");
            

            Mail::raw($tasksString, function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Weekly Task Report');
            });
        }

        $this->info('Report sent successfully.');
    }
}
