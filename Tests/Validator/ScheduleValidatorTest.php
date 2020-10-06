<?php

use Cron\CronBundle\Validator\Schedule;
use Cron\CronBundle\Validator\ScheduleValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class ScheduleValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator()
    {
        return new ScheduleValidator();
    }

    public function testValidSchedule()
    {
        $this->validator->validate('0 0 * * *', new Schedule());
        $this->assertNoViolation();
    }

    public function testValidSlashSchedule()
    {
        $this->validator->validate('*/5 4 * * *', new Schedule());
        $this->assertNoViolation();
    }

    public function testInvalidDayOfWeekSchedule()
    {
        $this->validator->validate('0 0 * * k', new Schedule());
        $this->buildViolation('Invalid day of week "k".')
            ->assertRaised();
    }

    public function testInvalidSchedule()
    {
        $this->validator->validate('test', new Schedule());
        $this->buildViolation('Invalid minute "test".')
            ->assertRaised();
    }
}
