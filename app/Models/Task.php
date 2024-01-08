<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function subtasks(): HasMany
    {
        return $this->hasMany(Subtask::class);
    }

    public function lable(): MorphOne // todo: avoid misspelling
    {
        return $this->morphOne(Lable::class , 'foreign');
    }

    public function files(): MorphMany
    {
        return $this->morphMany(Lable::class , 'foreign');
    }
}
