<?php

namespace App\Http\Controllers\Subtask;

use App\DTO\Subtask\Request\RequestUpdateSubtaskDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subtask\UpdateSubtaskRequest;
use App\Models\Label;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Subtask;
use App\Models\Task;
use App\Services\Subtask\UpdateSubtask\UpdateSubtaskServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UpdateSubtaskController extends Controller
{
    public function __invoke(UpdateSubtaskRequest          $request,
                             Project                       $project,
                             Task                          $task,
                             Subtask                       $subtask,
                             UpdateSubtaskServiceInterface $updateSubtaskService): JsonResponse
    {
        $data = RequestUpdateSubtaskDTO::fromRequest(
            subtask: $subtask,
            name: $request->name,
            description: $request->description,
            deadline: $request->deadline,
            label: $request->label_id ? Label::find($request->label_id) : null,
            projectUser: ProjectUser::where('user_id', $request->user_id)
                ->where('project_id', $project->id)->first()
        );

        $response_data = $updateSubtaskService->update($data);

        return Response::success($response_data);
    }
}
