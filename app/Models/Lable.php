<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Lable extends Model
{
    use HasFactory;


    public function foreign():MorphTo
    {
        return $this->morphTo();
    }
}
