<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Country
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Country
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
     * @ORM\Column(name="code", type="string", length=10)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @var ArrayCollection|Place[]
     * 
     * @ORM\OneToMany(targetEntity="Place", mappedBy="country")
     */
    private $places;
    
    
    
    public function __construct()
    {
    	$this->places = new ArrayCollection();
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
     * Set code
     *
     * @param string $code
     *
     * @return Country
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Country
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
     * Add place
     *
     * @param Place $place
     * @return Country
     */
    public function addPlace(Place $place = null)
    {
        $this->places->add($place);
        $place->setCountry($this);

        return $this;
    }

    /**
     * Remove place
     *
     * @param Place $place
     * @return Country
     */
    public function removePlace(Place $place = null)
    {
    	if ($this->places->contains($place)) {
    		$this->places->removeElement($place);
    		$place->setCountry(null);
    	}
        return $this;
    }

    /**
     * Get places
     *
     * @return ArrayCollection|Place[]
     */
    public function getPlaces()
    {
        return $this->places;
    }
}

