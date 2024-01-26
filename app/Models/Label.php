<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $id
 * @property mixed $color
 * @property mixed $title
 * @property mixed $project
 * @method static create(array $array)
 * @method static find(mixed $label_id)
 */
class Label extends Model
{
    use HasFactory;

    protected $fillable = [
        'color',
        'title',
        'project_id',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function label_assign(): HasMany
    {
        return $this->hasMany(Label_assign::class);
    }
}
