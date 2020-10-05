<?php

namespace Cron\CronBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Command extends Constraint
{
    public function validatedBy()
    {
        return CommandValidator::class;
    }
}