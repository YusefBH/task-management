<?php

namespace App\Models;

use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Subtask extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'deadline',
    ];

    public function project_user(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function lable() : MorphOne
    {
        return $this->morphOne(Lable::class , 'foreign');
    }

}
