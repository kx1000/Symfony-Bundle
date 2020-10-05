<?php

namespace Cron\CronBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Schedule extends Constraint
{
    public function validatedBy()
    {
        return ScheduleValidator::class;
    }
}