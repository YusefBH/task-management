<?php

namespace App\Services\Label\CreateLabel;

use App\DTO\Label\LabelDTO;
use App\DTO\Label\Request\RequestCreateLabelDTO;
use App\Exceptions\NotCreatedException;
use App\Models\Label;
use Exception;

class CreateLabelServiceConcrete implements CreateLabelServiceInterface
{
    /**
     * @throws NotCreatedException
     */
    public function create(RequestCreateLabelDTO $labelDTO): LabelDTO
    {
        try {
            $label = Label::create([
                'color' => $labelDTO->color,
                'title' => $labelDTO->title,
                'project_id' => $labelDTO->project->id,
            ]);
            return LabelDTO::fromModel(label: $label);
        } catch (Exception $exception) {
            throw new NotCreatedException();
        }
    }
}
