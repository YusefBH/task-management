<?php

namespace App\Http\Controllers\Task;

use App\DTO\Task\Request\RequestIndexTaskDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\IndexTaskRequest;
use App\Models\Project;
use App\Services\Task\IndexTask\IndexTaskServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class IndexTaskController extends Controller
{
    public function __invoke(IndexTaskRequest          $request,
                             Project                   $project,
                             IndexTaskServiceInterface $indexTaskService): JsonResponse
    {
        if ($request->has('status')) {
            $data = RequestIndexTaskDTO::fromRequest(
                project: $project,
                status: $request->status
            );
        } else {
            $data = RequestIndexTaskDTO::fromRequest(
                project: $project,
                status: null
            );
        }

        $responseData = $indexTaskService->index($data);

        return Response::success($responseData);
    }
}
