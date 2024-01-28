<?php

namespace App\DTO\Label;

use App\Models\Label;
use RuntimeException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class LabelDTO extends \App\Models\Label
{
    public function __construct(
        public string $id,
        public ?string $title,
        public ?string $color,
        public string $project_id,
    )
    {
    }

    public static function fromModel(Label $label): LabelDTO
    {
        try {
            return new self(
                id: $label->id,
                title: $label->title,
                color: $label->color,
                project_id: $label->project->id
            );
        } catch (UnknownProperties $e) {
            throw  new RuntimeException($e->getMessage());
        }
    }
}

