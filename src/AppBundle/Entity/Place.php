<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Place
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Place
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    
    /**
     * @var Gallery
     * 
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Gallery", inversedBy="place", cascade={"persist"})
     */
	private $gallery;
    
    /**
     * @var Country
     * 
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="places")
     * @ORM\JoinColumn()
     */
    private $country;
    
    /**
     * @var ArrayCollection|Event[]
     * 
     * @ORM\OneToMany(targetEntity="Event", mappedBy="place")
     */
    private $events;
    
    
    
    public function __construct()
    {
    	$this->events = new ArrayCollection();
    }
    
    public function __toString()
    {
    	return $this->name;
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
     *
     * @return Place
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
     *
     * @return Place
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
     * Set gallery
     *
     * @param Gallery $gallery
     *
     * @return Place
     */
    public function setGallery(Gallery $gallery = null)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * Set country
     *
     * @param Country $country
     *
     * @return Place
     */
    public function setCountry(Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Add event
     *
     * @param Event $event
     * @return Place
     */
    public function addEvent(Event $event = null)
    {
        $this->events->add(event);
        $event->setPlace($this);

        return $this;
    }

    /**
     * Remove event
     *
     * @param Event $event
     * @return Place
     */
    public function removeEvent(Event $event = null)
    {
    	if ($this->events->contains($event)) {
    		$this->events->removeElement($event);
    		$event->setPlace(null);
    	}
        return $this;
    }

    /**
     * Get events
     *
     * @return ArrayCollection|Event[]
     */
    public function getEvents()
    {
        return $this->events;
    }
}

