<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $rule
 * @property mixed $project
 * @method static create(array $array)
 */
class ProjectUser extends Model
{
    use HasFactory;

    // todo: use enums
    const RULE_OWNER = 'OWNER';
    const RULE_MEMBER = 'MEMBER';
    const RULE_VIEWER = 'VIEWER';
    const RULE = [self::RULE_OWNER, self::RULE_MEMBER, self::RULE_VIEWER];

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
