<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DaedlineRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //todo : if get time in format , convert to timestamp
        $now = Carbon::now()->timestamp;
        if ($value<=$now) {
            $fail("The {$attribute} is invalid.");
        }
    }
}
