<?php

namespace App\Http\Controllers\Task;

use App\DTO\Task\Request\RequestShowTaskDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\ShowTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Services\Task\ShowTask\ShowTaskServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ShowTaskController extends Controller
{
    public function __invoke(ShowTaskRequest          $request,
                             Project                  $project,
                             Task                     $task,
                             ShowTaskServiceInterface $showTaskService): JsonResponse
    {
        $data = RequestShowTaskDTO::fromRequest(task: $task);

        $response_data = $showTaskService->show($data);

        return Response::success($response_data);
    }
}
