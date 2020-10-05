<?php

namespace Cron\CronBundle\Validator;

use Cron\Exception\InvalidPatternException;
use Cron\Validator\CrontabValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ScheduleValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof Schedule) {
            throw new UnexpectedTypeException($constraint, Schedule::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        $cronValidator = new CrontabValidator();
        try {
            $cronValidator->validate($value);
        } catch (InvalidPatternException $e) {
            $this->context->buildViolation($e->getMessage())
                ->addViolation();
        }
    }
}