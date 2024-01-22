<?php

namespace App\Http\Controllers\Label;

use App\DTO\Label\Request\RequestUpdateLabelDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Label\UpdateLabelRequest;
use App\Models\Label;
use App\Models\Project;
use App\Services\Label\UpdateLabel\UpdateLabelServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UpdateLabelController extends Controller
{
    public function __invoke(UpdateLabelRequest          $request,
                             Project                     $project,
                             Label                       $label,
                             UpdateLabelServiceInterface $updateLabelService): JsonResponse
    {
        $data = RequestUpdateLabelDTO::fromRequest(
            label: $label,
            color: $request->color,
            title: $request->title,
        );

        $response_data = $updateLabelService->update($data);

        return Response::success($response_data);
    }
}
