<?php

namespace Cron\CronBundle\Entity;

use Cron\CronBundle\Validator\Command;
use Cron\CronBundle\Validator\Schedule;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CronJob
 *
 * @ORM\Table(name="cron_job", uniqueConstraints={@ORM\UniqueConstraint(name="un_name", columns={"name"})})
 * @ORM\Entity(repositoryClass="Cron\CronBundle\Entity\CronJobRepository")
 * @UniqueEntity("name")
 */
class CronJob
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=191, unique=true)
     * @Assert\NotNull
     * @Assert\Length(max=191)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="command", type="string", length=1024)
     * @Assert\NotNull
     * @Assert\Length(max=1024)
     * @Command
     */
    private $command;

    /**
     * @var string
     *
     * @ORM\Column(name="schedule", type="string", length=191)
     * @Assert\NotNull
     * @Assert\Length(max=191)
     * @Schedule
     */
    private $schedule;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=191, nullable=true)
     * @Assert\Length(max=191)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     * @Assert\Type("bool")
     */
    private $enabled;

    /**
     * @ORM\OneToMany(targetEntity="CronReport", mappedBy="job", cascade={"remove"})
     * @ORM\OrderBy({"id"="DESC"})
     * @var ArrayCollection
     */
    protected $reports;

    public function __construct()
    {
        $this->reports = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param  string  $name
     * @return CronJob
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $command
     * @return CronJob
     */
    public function setCommand($command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param string $schedule
     * @return CronJob
     */
    public function setSchedule($schedule)
    {
        $this->schedule = $schedule;

        return $this;
    }

    /**
     * @return string
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * Set description
     *
     * @param  string  $description
     * @return CronJob
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set enabled
     *
     * @param  boolean $enabled
     * @return CronJob
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getReports()
    {
        return $this->reports;
    }

    public function __toString()
    {
        return $this->name;
    }
}
