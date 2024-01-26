<?php

namespace App\Http\Controllers\Task;

use App\DTO\Task\Request\RequestCreateTaskDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Models\Label;
use App\Models\Project;
use App\Services\Task\CreateTask\CreateTaskServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CreateTaskController extends Controller
{
    public function __invoke(CreateTaskRequest          $request,
                             Project                    $project,
                             CreateTaskServiceInterface $createTaskService): JsonResponse
    {
        $data = RequestCreateTaskDTO::fromRequest(
            name: $request->name,
            status: $request->status,
            project: $project,
            label: $request->label_id ? Label::find($request->label_id) : null,
        );
        $response_data = $createTaskService->create($data);

        return Response::success($response_data, 201);
    }
}
