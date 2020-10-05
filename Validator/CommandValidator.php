<?php

namespace Cron\CronBundle\Validator;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class CommandValidator extends ConstraintValidator
{
    private $application;

    public function __construct(KernelInterface $kernel)
    {
        $this->application = new Application($kernel);
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof Command) {
            throw new UnexpectedTypeException($constraint, Command::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        $parts = explode(' ', $value);
        try {
            $this->application->get((string) $parts[0]);
        } catch (CommandNotFoundException $e) {
            $this->context->buildViolation($e->getMessage())
                ->addViolation();
        }
    }
}