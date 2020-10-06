<?php

use Cron\CronBundle\Validator\Command;
use Cron\CronBundle\Validator\CommandValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;
use Symfony\Component\Console\Command\Command as ConsoleCommand;

class CommandValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator()
    {
        return new CommandValidator([
            new ConsoleCommand('cron:run'),
            new ConsoleCommand('cron:create'),
        ]);
    }

    public function testValidCommand()
    {
        $this->validator->validate('cron:run', new Command());
        $this->assertNoViolation();
    }

    public function testValidCommandWithArgument()
    {
        $this->validator->validate('cron:create test', new Command());
        $this->assertNoViolation();
    }

    public function testInvalidCommand()
    {
        $constraint = new Command();
        $commandName = 'app:invalid';
        $this->validator->validate($commandName, $constraint);
        $this->buildViolation($constraint->message)
            ->setParameter('{{ name }}', $commandName)
            ->assertRaised();
    }
}
