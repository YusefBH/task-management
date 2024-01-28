<?php

namespace App\Http\Controllers\Subtask;

use App\DTO\Subtask\Request\RequestShowSubtaskDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subtask\ShowSubtaskRequest;
use App\Models\Project;
use App\Models\Subtask;
use App\Models\Task;
use App\Services\Subtask\ShowSubtask\ShowSubtaskServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ShowSubtaskController extends Controller
{
    public function __invoke(ShowSubtaskRequest          $request,
                             Project                     $project,
                             Task                        $task,
                             Subtask                     $subtask,
                             ShowSubtaskServiceInterface $showSubtaskService): JsonResponse
    {
        $data = RequestShowSubtaskDTO::fromRequest(subtask: $subtask);

        $response_data = $showSubtaskService->show($data);

        return Response::success($response_data);
    }
}
