<?php

namespace Cron\CronBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class CommandValidator extends ConstraintValidator
{
    private $commands;

    public function __construct(iterable $commands)
    {
        $this->commands = $commands;
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
        $commandName = (string) $parts[0];
        if (!$this->isCommandRegistered($commandName)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ name }}', $commandName)
                ->addViolation();
        }
    }

    private function isCommandRegistered(string $name): bool
    {
        foreach ($this->commands as $command) {
            if ($name === $command->getName()) {
                return true;
            }
        }

        return false;
    }
}