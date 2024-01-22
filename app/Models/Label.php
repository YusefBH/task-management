<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $id
 * @property mixed $color
 * @property mixed $title
 */
class Label extends Model
{
    use HasFactory;

    protected $fillable = [
        'color',
        'title',
    ];

    public function project():BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
