<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Lable extends Model // todo: avoid misspelling
{
    use HasFactory;


    public function foreign():MorphTo
    {
        return $this->morphTo();
    }
}
