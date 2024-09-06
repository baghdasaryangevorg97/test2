<?php

namespace App\Http\Controllers;

use App\Services\UserTaskStatisticService;
use Illuminate\Http\Request;

class UserTaskStatisticController extends Controller
{

    protected UserTaskStatisticService $taskService;

    public function __construct(UserTaskStatisticService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index($id)
    {
        $data = $this->taskService->index($id);

        return response()->json($data);
    }

}
