<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DateMatch extends Constraint
{
    public $message = 'La date choisie doit être supérieure ou égale à la date d\'aujourd\'hui.';
}