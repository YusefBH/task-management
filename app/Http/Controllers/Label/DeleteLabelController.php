<?php

namespace App\Http\Controllers\Label;

use App\DTO\Label\Request\RequestDeleteLabelDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Label\DeleteLabelRequest;
use App\Models\Label;
use App\Models\Project;
use App\Services\Label\DeleteLabel\DeleteLabelServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeleteLabelController extends Controller
{
    public function __invoke(DeleteLabelRequest          $request,
                             Project                     $project,
                             Label                       $label,
                             DeleteLabelServiceInterface $deleteLabelService): JsonResponse
    {
        $data = RequestDeleteLabelDTO::fromRequest(
            label: $label
        );
        $responseData = $deleteLabelService->delete($data);
        return Response::success($responseData);
    }
}
