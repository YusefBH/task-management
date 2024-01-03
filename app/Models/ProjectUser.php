<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectUser extends Model
{
    use HasFactory;

    const RULE_OWNER = 'owner';
    const RULE_MEMBER = 'member';
    const RULE_Viewer = 'viewer';
    const RULE = [self::RULE_OWNER , self::RULE_MEMBER , self::RULE_Viewer];

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
}
