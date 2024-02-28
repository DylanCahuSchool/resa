<?php

namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="event")
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $location;

    /**
    * @ORM\OneToMany(targetEntity="Attendee", mappedBy="event", cascade={"persist"})
    * @var ArrayCollection|Attendee[]
    */
    protected $attendees;

    /**
    * @param $name
    * @param $location
    */
    public function __construct($name, $location)
    {
        $this->name = $name;
        $this->location  = $location;

        $this->attendees = new ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }
    
    public function addAttendee(Attendee $attendee)
    {
        if(!$this->attendees->contains($attendee)) {
            $attendee->setEvent($this);
            $this->attendees->add($attendee);
        }
    }

    public function getAttendees()
    {
        return $this->attendees;
    }
}