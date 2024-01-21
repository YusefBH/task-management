<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $description
 * @property mixed $deadline
 * @property mixed $project_user_id
 * @property mixed $task_id
 * @property mixed $task
 */
class Subtask extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'deadline',
        'project_user_id',
        'task_id'
    ];

    public function project_user(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function label(): MorphOne
    {
        return $this->morphOne(Label::class, 'foreign');
    }

}
