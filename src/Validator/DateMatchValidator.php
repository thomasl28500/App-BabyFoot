<?php

// nommage choisi en fonction de la doc Symfony 

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DateMatchValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $currentDate = new \DateTime();

        if ($value < $currentDate) { // si la date du match est inférieure à la date du jour
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}