<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRepository")
 * @Table(name="events")
 */
class Event
{
    const ENTITY_PATH = 'AppBundle\Entity\Event';
    const TYPE_ALL_DAY = 'ALL DAY';
    const TYPE_NORMAL = 'NORMAL';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=500)
     */
    protected $name;


    /**
     * @var string
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

    /**
     * @var integer
     * @ORM\Column(name="start_time", type="integer")
     */
    protected $startTime;


    /**
     * @var integer
     * @ORM\Column(name="end_time", type="integer")
     */
    protected $endTime;

    /**
     * @var string
     * @ORM\Column(name="type", type="string", length=30)
     */
    protected $type;


    /**
     * @param $eventDetails  array ( title, description, startTime, endTime, type)
     */
    public function __construct($eventDetails)
    {
        $this->type  = isset($eventDetails['type'])? $eventDetails['type']: self::TYPE_NORMAL;
        $this->name = $eventDetails['title'];
        $this->description = $eventDetails['description'];
        $this->startTime = $eventDetails['startTime'];
        $this->endTime = $eventDetails['endTime'];

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
     * @param string $name
     * @return Evente
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
     * Set description
     *
     * @param string $description
     * @return Evente
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
     * Set startTime
     *
     * @param integer $startTime
     * @return Evente
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return integer
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param integer $endTime
     * @return Evente
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return integer
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Evente
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}