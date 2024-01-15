<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class InvitationErrorException extends Exception
{
    public function render(): JsonResponse
    {
        Log::error($this->getMessage());
        return response()->json([
            'massage' => 'Invitation error please check again',
        ],500);
    }
}
