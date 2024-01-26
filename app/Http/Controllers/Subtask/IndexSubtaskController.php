<?php

namespace App\Http\Controllers\Subtask;

use App\DTO\Subtask\Request\RequestIndexSubtaskDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subtask\IndexSubtaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Services\Subtask\IndexSubtask\IndexSubtaskServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class IndexSubtaskController extends Controller
{
    public function __invoke(IndexSubtaskRequest          $request,
                             Project                      $project,
                             Task                         $task,
                             IndexSubtaskServiceInterface $indexSubtaskService): JsonResponse
    {

        $data = RequestIndexSubtaskDTO::fromRequest(
            task: $task
        );

        $responseData = $indexSubtaskService->index($data);

        return Response::success($responseData);
    }
}
