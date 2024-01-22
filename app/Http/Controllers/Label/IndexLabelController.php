<?php

namespace App\Http\Controllers\Label;

use App\DTO\Label\Request\RequestIndexLabelDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Label\IndexLabelRequest;
use App\Models\Project;
use App\Services\Label\IndexLabel\IndexLabelServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class IndexLabelController extends Controller
{
    public function __invoke(IndexLabelRequest          $request,
                             Project                    $project,
                             IndexLabelServiceInterface $indexLabelService): JsonResponse
    {

        $data = RequestIndexLabelDTO::fromRequest(
            project: $project,
        );


        $responseData = $indexLabelService->index($data);

        return Response::success($responseData);
    }
}
