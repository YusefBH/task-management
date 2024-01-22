<?php

namespace App\Services\Label\IndexLabel;

use App\DTO\Label\LabelDTO;
use App\DTO\Label\Request\RequestIndexLabelDTO;
use App\DTO\Pagination\Pagination;
use App\Models\Label;

class IndexLabelServiceConcrete implements IndexLabelServiceInterface
{
    public function index(RequestIndexLabelDTO $labelDTO): Pagination
    {
        $pagination = $labelDTO->project->labels()->paginate(5);
        $tasks = $pagination->map(fn(Label $label) => LabelDTO::fromModel(
            label: $label
        ));

        return Pagination::fromModelPaginatorAndData(
            paginator: $pagination, data: $tasks->toArray()
        );
    }
}
