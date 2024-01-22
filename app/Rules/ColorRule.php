<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ColorRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $colorRegex = '~^(#)([0-9]|[a-f]){6}$~';
        if (!preg_match($colorRegex, $value)) {
            $fail("The {$attribute} is invalid.");
        }
    }
}
