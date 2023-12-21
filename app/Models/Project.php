<?php

namespace App\Models;

use App\Models\ProjectUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable =[
      'name',
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

    public function files()
    {
        return $this->morphMany(File::class , 'foreign');
    }

}
