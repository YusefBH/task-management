<?php

namespace App\Exceptions\Invitation;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class NotAcceptedException extends Exception
{
    public function render(): JsonResponse
    {
        Log::error($this);
        return response()->json([
            'massage' => 'not accepted',
        ],500);
    }
}
