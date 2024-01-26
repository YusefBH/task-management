<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class NotDeletedException extends Exception
{
    public function render(): JsonResponse
    {
        Log::error($this);
        return response()->json([
            'massage' => 'not deleted',
        ],500);
    }
}
