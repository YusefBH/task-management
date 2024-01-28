<?php

namespace App\Http\Controllers\Subtask;

use App\DTO\Subtask\Request\RequestCreateSubtaskDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subtask\CreateSubtaskRequest;
use App\Models\Label;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Task;
use App\Services\Subtask\CreateSubtask\CreateSubtaskServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CreateSubtaskController extends Controller
{
    public function __invoke(CreateSubtaskRequest          $request,
                             Project                       $project,
                             Task                          $task,
                             CreateSubtaskServiceInterface $createSubtaskService): JsonResponse
    {
        $data = RequestCreateSubtaskDTO::fromRequest(
            name: $request->name,
            description: $request->description,
            deadline: $request->deadline,
            task: $task,
            label: $request->label_id ? Label::find($request->label_id) : null,
            projectUser: ProjectUser::where('user_id', $request->user_id)->where('project_id', $project->id)->first()
        );
        $response_data = $createSubtaskService->create($data);

        return Response::success($response_data, 201);
    }
}
