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
    public function store(TaskRequest $request): TaskResource|JsonResponse
    {
        $data = $this->taskService->create($request->validated());

        if(is_array($data)) {
            return response()->json(['message' => $data['message'], 'success' => $data['success']], 422);
        }

        return new TaskResource($data);
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
    public function update(TaskRequest $request, int $id): TaskResource|JsonResponse
    {
        $data = $this->taskService->update($request->validated(), $id);

        if(is_array($data)) {
            return response()->json(['message' => $data['message'], 'success' => $data['success']], 422);
        }

        return new TaskResource($data);
    }

    /**
     * Remove the specified task.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $removed = $this->taskService->destroy($id);

        if (!$removed) {
            return response()->json(null, Response::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'Task deleted successfully'], Response::HTTP_OK);
    }
}
