<?php

namespace App\Http\Controllers\Task;

use App\DTO\Task\Request\RequestUpdateTaskDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Label;
use App\Models\Project;
use App\Models\Task;
use App\Services\Task\UpdateTask\UpdateTaskServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UpdateTaskController extends Controller
{
    public function __invoke(UpdateTaskRequest          $request,
                             Project                    $project,
                             Task                       $task,
                             UpdateTaskServiceInterface $updateTaskService): JsonResponse
    {
        $data = RequestUpdateTaskDTO::fromRequest(
            task: $task,
            name: $request->name,
            status: $request->status,
            label: $request->label_id ? Label::find($request->label_id) : null,
        );

        $response_data = $updateTaskService->update($data);

        return Response::success($response_data);
    }
}
