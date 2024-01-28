<?php

namespace App\Http\Controllers\Subtask;

use App\DTO\Subtask\Request\RequestDeleteSubtaskDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subtask\DeleteSubtaskRequest;
use App\Models\Project;
use App\Models\Subtask;
use App\Models\Task;
use App\Services\Subtask\DeleteSubtask\DeleteSubtaskServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeleteSubtaskController extends Controller
{
    public function __invoke(DeleteSubtaskRequest          $request,
                             Project                       $project,
                             Task                          $task,
                             Subtask                       $subtask,
                             DeleteSubtaskServiceInterface $deleteSubtaskService): JsonResponse
    {
        $data = RequestDeleteSubtaskDTO::fromRequest(subtask: $subtask);

        $responseData = $deleteSubtaskService->delete($data);

        return Response::success($responseData);
    }
}
