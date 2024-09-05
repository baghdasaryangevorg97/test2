<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the tasks.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $tasks = $this->taskService->getUserAllTasks();
        
        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created task.
     *
     * @param TaskRequest $request
     * @return TaskResource
     */
    public function store(TaskRequest $request): TaskResource
    {
        $task = $this->taskService->create($request->validated());

        return new TaskResource($task);
    }

    /**
     * Display the specified task.
     *
     * @param int $id
     * @return TaskResource
     */
    public function show(int $id): TaskResource
    {
        $task = $this->taskService->getTaskById($id);

        return new TaskResource($task);
    }

    /**
     * Update the specified task.
     *
     * @param TaskRequest $request
     * @param int $id
     * @return TaskResource
     */
    public function update(TaskRequest $request, int $id): TaskResource
    {
        $task = $this->taskService->update($request->validated(), $id);

        return new TaskResource($task);
    }

    /**
     * Remove the specified task.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->taskService->destroy($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
