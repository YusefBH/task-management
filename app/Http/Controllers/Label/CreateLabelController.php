<?php

namespace App\Http\Controllers\Label;

use App\DTO\Label\Request\RequestCreateLabelDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Label\CreateLabelRequest;
use App\Models\Project;
use App\Services\Label\CreateLabel\CreateLabelServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CreateLabelController extends Controller
{
    public function __invoke(CreateLabelRequest          $request,
                             Project                     $project,
                             CreateLabelServiceInterface $createLabelService): JsonResponse
    {
        $data = RequestCreateLabelDTO::fromRequest(
            color: $request->color,
            title: $request->title,
            project: $project,
        );
        $response_data = $createLabelService->create($data);

        return Response::success($response_data, 201);
    }
}
