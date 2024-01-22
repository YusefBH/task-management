<?php

namespace App\DTO\Label;

use App\Models\Label;
use RuntimeException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class LabelDTO
{
    public function __construct(
        public string $id,
        public string $title,
        public string $color,
    )
    {
    }

    public static function fromModel(Label $task): LabelDTO
    {
        try {
            return new self(
                id: $task->id,
                title: $task->title,
                color: $task->color,
            );
        } catch (UnknownProperties $e) {
            throw  new RuntimeException($e->getMessage());
        }
    }
}

