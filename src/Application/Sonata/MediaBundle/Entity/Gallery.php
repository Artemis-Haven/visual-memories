<?php

namespace Application\Sonata\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use AppBundle\Entity\Person;
use AppBundle\Entity\Place;
use AppBundle\Entity\Event;

/**
 *
 * @ORM\Table(name="media__gallery")
 * @ORM\Entity()
 */
class Gallery extends BaseGallery
{
    /**
     * @var int $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Person
     * 
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Person", mappedBy="gallery")
     */
	private $person;
    
    /**
     * @var Event
     * 
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Event", mappedBy="gallery")
     */
	private $event;
    
    /**
     * @var Place
     * 
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Place", mappedBy="gallery")
     */
	private $place;
	
	
	public function __toString()
	{
		if ($this->person)
			return (string) $this->person;
		if ($this->event)
			return (string) $this->event;
		if ($this->place)
			return (string) $this->place;
		return $this->name;
	}
	

    /**
     * Get id
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return Person
     */
    public function getPerson()
    {
    	return $this->person;
    }
    
    /**
     * @param Person $person
     * @return Gallery
     */
    public function setPerson(Person $person = null)
    {
    	$this->person = $person;
    	return $this;
    }
    
    /**
     * @return Event
     */
    public function getEvent()
    {
    	return $this->event;
    }
    
    /**
     * @param Event $event
     * @return Gallery
     */
    public function setEvent(Event $event = null)
    {
    	$this->event = $event;
    	return $this;
    }
    
    /**
     * @return Place
     */
    public function getPlace()
    {
    	return $this->place;
    }
    
    /**
     * @param Place $place
     * @return Gallery
     */
    public function setPlace(Place $place = null)
    {
    	$this->place = $place;
    	return $this;
    }
    
    public function getMaxPosition()
    {
    	$max = 0;
    	foreach ($this->galleryHasMedias as $item) {
    		if ($item->getPosition() > $max)
    			$max = $item->getPosition();
    	}
    	return $max;
    }
}
