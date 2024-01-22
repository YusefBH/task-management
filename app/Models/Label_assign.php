<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Label_assign extends Model
{
    use HasFactory;

    protected $fillable = [
        'label_id',
        'foreign_type',
        'foreign_id',
    ];

    public function foreign():MorphTo
    {
        return $this->morphTo();
    }
}
