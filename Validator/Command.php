<?php

namespace Cron\CronBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Command extends Constraint
{
    public $message = 'The command "{{ name }}" does not exist.';

    public function validatedBy()
    {
        return CommandValidator::class;
    }
}