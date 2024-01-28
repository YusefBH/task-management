<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property mixed $project
 * @property mixed $user
 * @property mixed $role
 * @property mixed $id
 * @method static create(array $array)
 * @method static find(mixed $project_user_id)
 * @method static where(string $string, mixed $user_id)
 */
class ProjectUser extends Model
{
    use HasFactory;
    use HasRoles;

    protected $casts = [
        'ROLE' => Role::class,
    ];

    protected $fillable = [
        'role',
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

    public function scopeRole(Builder $query, $role): void
    {
        $query->where('role', $role);
    }
}
