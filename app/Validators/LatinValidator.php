<?php

namespace Validators;
use Src\Validator\AbstractValidator;
class LatinValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно состоять из a-zA-Z, цифры или "_"';

    public function rule(): bool
    {
        return (boolean) preg_match('#^[a-zA-Z]*\d*_$#', $this->value);
    }
}