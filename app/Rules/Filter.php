<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Filter implements ValidationRule
{

    protected $forbidden;

    public function __construct($forbidden)
    {
        $this->forbidden = $forbidden;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        in_array(strtolower($value), $this->forbidden);
        $fail('This name is not found');
    }

    // in laravel 9 filter was contain function passes and message but in laravel 10 you write all code in validate function without return key word
    /*   function passes($attribute, $value){
        return ! in_array(strtolower($value), $this->forbidden);
    }

    public function message(){
        return ' This value is not allowed';
    } */
}
