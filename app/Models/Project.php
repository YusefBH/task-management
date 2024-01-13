<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $description
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
        return $this->project_users()->where('rule', '=', ProjectUser::RULE_OWNER)->first();
    }

}
