<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $description
 * @property mixed $project_users
 * @method static create(array $array)
 * @method static inRandomOrder()
 */
class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function project_users(): HasMany
    {
        return $this->hasMany(ProjectUser::class);
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'foreign');
    }

    public function owner(): Model|HasMany|null
    {
        return $this->project_users()->where('role', '=', Role::ROLE_OWNER)->first();
    }

    public function labels(): HasMany
    {
        return $this->hasMany(Label::class);
    }
}
