<?php namespace Malahierba\ChileRut\Rules;

use Illuminate\Contracts\Validation\Rule;
use Malahierba\ChileRut\ChileRut;

/**
 * Class Malahierba\ChileRut\Rules\ValidChileanRut
 *
 * Validation rule to chilean RUT
 */
class ValidChileanRut implements Rule
{

    /**
     * @var ChileRut $chileRUT
     */
    private $chileRUT;


    /**
     * Create a new rule instance.
     *
     * @param ChileRut $chileRUT
     *
     * @return void
     */
    public function __construct(ChileRut $chileRUT)
    {
        $this->chileRUT = $chileRUT;
    }


    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  string $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->chileRUT->check($value);
    }


    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is not valid.';
    }
}
