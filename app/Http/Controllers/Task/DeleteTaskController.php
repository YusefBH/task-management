<?php

namespace App\Http\Controllers\Task;

use App\DTO\Task\Request\RequestDeleteTaskDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\DeleteTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Services\Task\DeleteTask\DeleteTaskServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeleteTaskController extends Controller
{
    public function __invoke(DeleteTaskRequest          $request,
                             Project                    $project,
                             Task                       $task,
                             DeleteTaskServiceInterface $deleteTaskService): JsonResponse
    {
        $data = RequestDeleteTaskDTO::fromRequest(
            task: $task
        );
        $responseData = $deleteTaskService->delete($data);
        return Response::success($responseData);
    }
}
