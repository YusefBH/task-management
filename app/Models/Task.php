<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $status
 * @property mixed $project_id
 * @property mixed $task_label
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'project_id'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function subtasks(): HasMany
    {
        return $this->hasMany(Subtask::class);
    }

    public function task_label(): MorphOne
    {
        return $this->morphOne(Label_assign::class, 'foreign');
    }

    public function files(): MorphMany
    {
        return $this->morphMany(Label::class, 'foreign');
    }

    public function scopeStatus(Builder $query, $status): void
    {
        $query->where('status', $status);
    }
}
