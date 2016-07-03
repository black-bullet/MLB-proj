<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Schedule Entity
 *
 * @author Yevgeniy Zholkevskiy <zhenya.zholkevskiy@gmail.com>
 *
 * @ORM\Table(name="schedules")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ScheduleRepository")
 */
class Schedule
{
    /**
     * @var int $id ID
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $homeTeam Home team
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @Assert\Length(min="2", max="255")
     * @Assert\Type(type="string")
     * @Assert\NotBlank()
     */
    private $homeTeam;

    /**
     * @var string $awayTeam Away team
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @Assert\Length(min="2", max="255")
     * @Assert\Type(type="string")
     * @Assert\NotBlank()
     */
    private $awayTeam;

    /**
     * @var \DateTime $date Date
     *
     * @ORM\Column(type="datetime", nullable=false)
     *
     * @Assert\Type(type="datetime")
     */
    private $date;

    /**
     * @var int $stadiumID ID of stadium
     *
     * @ORM\Column(type="integer", nullable=false)
     *
     * @Assert\Type(type="integer")
     */
    private $stadiumID;

    /**
     * Get ID
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get home team
     *
     * @return string Home team
     */
    public function getHomeTeam()
    {
        return $this->homeTeam;
    }

    /**
     * Set home team
     *
     * @param string $homeTeam Home team
     *
     * @return $this
     */
    public function setHomeTeam($homeTeam)
    {
        $this->homeTeam = $homeTeam;

        return $this;
    }

    /**
     * Get away team
     *
     * @return string Away team
     */
    public function getAwayTeam()
    {
        return $this->awayTeam;
    }

    /**
     * Set away team
     *
     * @param string $awayTeam Away team
     *
     * @return $this
     */
    public function setAwayTeam($awayTeam)
    {
        $this->awayTeam = $awayTeam;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime Date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date
     *
     * @param \DateTime $date Date
     *
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get stadium ID
     *
     * @return int stadium ID
     */
    public function getStadiumID()
    {
        return $this->stadiumID;
    }

    /**
     * Set stadium ID
     *
     * @param int $stadiumID Stadium ID
     *
     * @return $this
     */
    public function setStadiumID($stadiumID)
    {
        $this->stadiumID = $stadiumID;

        return $this;
    }
}
