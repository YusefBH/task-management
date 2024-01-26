<?php

namespace App\Http\Controllers\Task;

use App\DTO\Task\Request\RequestRemoveLabelTaskDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\RemoveLabelTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Services\Task\RemoveLabelTask\RemoveLabelTaskServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;


class RemoveLabelTaskController extends Controller
{
    public function __invoke(RemoveLabelTaskRequest          $request,
                             Project                         $project,
                             Task                            $task,
                             RemoveLabelTaskServiceInterface $removeLabelTaskService): JsonResponse
    {
        $data = RequestRemoveLabelTaskDTO::fromRequest(task: $task);

        $response_data = $removeLabelTaskService->remove_label($data);

        return Response::success($response_data);
    }
}
