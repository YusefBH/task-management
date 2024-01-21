<?php

namespace App\DTO\Task;

use App\Models\Task;
use RuntimeException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class TaskDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $status,
        public string $project_id
    )
    {
    }

    public static function fromModel(Task $task): TaskDTO
    {
        try {
            return new self(
                id: $task->id,
                name: $task->name,
                status: $task->status,
                project_id:$task->project_id,
            );
        } catch (UnknownProperties $e) {
            throw  new RuntimeException($e->getMessage());
        }
    }
}

