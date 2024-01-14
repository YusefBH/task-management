<?php

namespace App\Models;

use App\Enums\Rule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property mixed $rule
 * @property mixed $project
 * @method static create(array $array)
 */
class ProjectUser extends Model
{
    use HasFactory;
    use HasRoles;

    protected $casts = [
        'RULE' => Rule::class,
    ];

    protected $fillable = [
        'rule',
        'user_id',
        'project_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function subtasks(): HasMany
    {
        return $this->hasMany(Subtask::class);
    }

    public function scopeRule(Builder $query, $rule): void
    {
        $query->where('rule', $rule);
    }
}
