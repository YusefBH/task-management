<?php

namespace App\Http\Controllers\Label;

use App\DTO\Label\Request\RequestShowLabelDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Label\ShowLabelRequest;
use App\Models\Label;
use App\Models\Project;
use App\Services\Label\ShowLabel\ShowLabelServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ShowLabelController extends Controller
{
    public function __invoke(ShowLabelRequest          $request,
                             Project                   $project,
                             Label                     $label,
                             ShowLabelServiceInterface $showLabelService): JsonResponse
    {
        $data = RequestShowLabelDTO::fromRequest(
            label: $label
        );

        $response_data = $showLabelService->show($data);

        return Response::success($response_data);
    }
}
