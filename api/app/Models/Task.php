<?php

namespace App\Models;

use App\Notifications\TaskDeadlineNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'description', 'status', 'due_date', 'completed_at'];

    protected $table = 'tasks';

    public function sendReminder()
    {
        $user = $this->user;
        $user->notify(new TaskDeadlineNotification($this));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
