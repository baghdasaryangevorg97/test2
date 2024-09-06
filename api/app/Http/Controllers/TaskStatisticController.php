<?php

namespace App\Http\Controllers;

use App\Services\TaskStatisticService;
use Illuminate\Http\Request;

class TaskStatisticController extends Controller
{

    protected TaskStatisticService $taskService;

    public function __construct(TaskStatisticService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        $data = $this->taskService->index();

        return response()->json($data);
    }
    
}
