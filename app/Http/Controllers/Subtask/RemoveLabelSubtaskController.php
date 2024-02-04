<?php

namespace App\Http\Controllers\Subtask;

use App\DTO\Subtask\Request\RequestRemoveLabelSubtaskDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subtask\RemoveLabelSubtaskRequest;
use App\Models\Project;
use App\Models\Subtask;
use App\Models\Task;
use App\Services\Subtask\RemoveLabelSubtask\RemoveLabelSubtaskServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;


class RemoveLabelSubtaskController extends Controller
{
    public function __invoke(RemoveLabelSubtaskRequest          $request,
                             Project                            $project,
                             Task                               $task,
                             Subtask                            $subtask,
                             RemoveLabelSubtaskServiceInterface $removeLabelSubtaskService): JsonResponse
    {
        $data = RequestRemoveLabelSubtaskDTO::fromRequest(subtask: $subtask);

        $response_data = $removeLabelSubtaskService->remove_label($data);

        return Response::success($response_data);
    }
}
