<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Sonata\MediaBundle\Entity\Gallery;

/**
 * Person
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Person
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
     * @var \DateTime
     *
     * @ORM\Column(name="birthDate", type="date", nullable=true)
     */
    private $birthDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deathDate", type="date", nullable=true)
     */
    private $deathDate;
    
   	const GENDER_MALE = "Homme";
   	const GENDER_FEMALE = "Femme";

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=10, nullable=true)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="middleName", type="string", length=255, nullable=true)
     */
    private $middleName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="maidenName", type="string", length=255, nullable=true)
     */
    private $maidenName;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;
    
    /**
     * @var ArrayCollection|CoupleRelationship[]
     * 
     * @ORM\OneToMany(targetEntity="CoupleRelationship", mappedBy="person1")
     */
    private $firstCoupleRelationships;
    
    /**
     * @var ArrayCollection|CoupleRelationship[]
     * 
     * @ORM\OneToMany(targetEntity="CoupleRelationship", mappedBy="person2")
     */
    private $secondCoupleRelationships;
    
    /**
     * @var ArrayCollection|ParentRelationship[]
     * 
     * @ORM\OneToMany(targetEntity="ParentRelationship", mappedBy="parent")
     */
    private $childrenRelationships;
    
    /**
     * @var ArrayCollection|ParentRelationship[]
     * 
     * @ORM\OneToMany(targetEntity="ParentRelationship", mappedBy="child")
     */
    private $parentsRelationships;
    
    /**
     * @var Gallery
     * 
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Gallery", cascade={"persist"})
     */
	private $gallery;
	
	/**
	 * @var ArrayCollection|Event[]
	 * 
 	 * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Event", cascade={"persist"}, mappedBy="persons")
	 */
	private $events;
    
    
    
    public function __construct()
    {
    	$this->childrenRelationships = new ArrayCollection();
    	$this->parentsRelationships = new ArrayCollection();
    	$this->firstCoupleRelationships = new ArrayCollection();
    	$this->secondCoupleRelationships = new ArrayCollection();
    	$this->events = new ArrayCollection();
    }
    
    public function __toString()
    {
    	return $this->firstName." ".$this->lastName;
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
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return Person
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set deathDate
     *
     * @param \DateTime $deathDate
     *
     * @return Person
     */
    public function setDeathDate($deathDate)
    {
        $this->deathDate = $deathDate;

        return $this;
    }

    /**
     * Get deathDate
     *
     * @return \DateTime
     */
    public function getDeathDate()
    {
        return $this->deathDate;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return Person
     */
    public function setGender($gender)
    {
    	if ($gender == null || in_array($gender, [self::GENDER_FEMALE, self::GENDER_MALE]))
	        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Person
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set middleName
     *
     * @param string $middleName
     *
     * @return Person
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;

        return $this;
    }

    /**
     * Get middleName
     *
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Person
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set maidenName
     *
     * @param string $maidenName
     *
     * @return Person
     */
    public function setMaidenName($maidenName)
    {
        $this->maidenName = $maidenName;

        return $this;
    }

    /**
     * Get maidenName
     *
     * @return string
     */
    public function getMaidenName()
    {
        return $this->maidenName;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return Person
     */
    public function setNotes($notes)
    {
        $this->$notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Add first part couple relationship
     *
     * @param CoupleRelationship $relation
     * @return Person
     */
    public function addFirstCoupleRelationship(CoupleRelationship $relation = null)
    {
        $this->firstCoupleRelationships->add($relation);
        $relation->setPerson1($this);

        return $this;
    }

    /**
     * Add second part couple relationship
     *
     * @param CoupleRelationship $relation
     * @return Person
     */
    public function addSecondCoupleRelationship(CoupleRelationship $relation = null)
    {
        $this->secondCoupleRelationships->add($relation);
        $relation->setPerson2($this);

        return $this;
    }

    /**
     * Remove couple relationship
     *
     * @param CoupleRelationship $relation
     * @return Person
     */
    public function removeCoupleRelationship(CoupleRelationship $relation = null)
    {
    	if ($this->firstCoupleRelationships->contains($relation)) {
    		$this->firstCoupleRelationships->removeElement($relation);
    		$relation->setPerson1(null);
    	}
    	if ($this->secondCoupleRelationships->contains($relation)) {
    		$this->secondCoupleRelationships->removeElement($relation);
    		$relation->setPerson2(null);
    	}
        return $this;
    }

    /**
     * Get first part couple relationships
     *
     * @return ArrayCollection|CoupleRelationship[]
     */
    public function getFirstCoupleRelationships()
    {
        return $this->firstCoupleRelationships;
    }

    /**
     * Get second part couple relationships
     *
     * @return ArrayCollection|CoupleRelationship[]
     */
    public function getSecondCoupleRelationships()
    {
        return $this->secondCoupleRelationships;
    }

    /**
     * Get couple relationships
     *
     * @return ArrayCollection|CoupleRelationship[]
     */
    public function getCoupleRelationships()
    {
        return new ArrayCollection(array_merge($this->firstCoupleRelationships->toArray(), $this->secondCoupleRelationships->toArray()));
    }

    /**
     * Add child relationship
     *
     * @param ParentRelationship $relation
     * @return Person
     */
    public function addChildRelationship(ParentRelationship $relation = null)
    {
        $this->childrenRelationships->add($relation);
        $relation->setChild($this);

        return $this;
    }

    /**
     * Add parent relationship
     *
     * @param ParentRelationship $relation
     * @return Person
     */
    public function addParentRelationship(ParentRelationship $relation = null)
    {
        $this->parentsRelationships->add($relation);
        $relation->setParent($this);

        return $this;
    }

    /**
     * Remove parent relationship
     *
     * @param ParentRelationship $relation
     * @return Person
     */
    public function removeParentRelationship(ParentRelationship $relation = null)
    {
    	if ($this->childrenRelationships->contains($relation)) {
    		$this->childrenRelationships->removeElement($relation);
    		$relation->setChild(null);
    	}
    	if ($this->parentsRelationships->contains($relation)) {
    		$this->parentsRelationships->removeElement($relation);
    		$relation->setParent(null);
    	}
        return $this;
    }

    /**
     * Get children relationships
     *
     * @return ArrayCollection|ParentRelationship[]
     */
    public function getChildrenRelationships()
    {
        return $this->childrenRelationships;
    }

    /**
     * Get parents relationships
     *
     * @return ArrayCollection|ParentRelationship[]
     */
    public function getParentsRelationships()
    {
        return $this->parentsRelationships;
    }
    
    public function getParents()
    {
    	$parents = [];
    	foreach ($this->getParentsRelationships() as $rel) {
    			$parents[] = $rel->getParent();
    	}
    	
    	return $parents;
    }
    
    public function getSiblings()
    {
    	$siblings = [];
    	foreach ($this->getParentsRelationships() as $parentRel) {
    		foreach ($parentRel->getParent()->getChildrenRelationships() as $childRel) {
    			if ($childRel->getChild() != $this && !in_array($childRel->getChild(), $siblings))
    				$siblings[] = $childRel->getChild();
    		}
    	}
    	
    	return $siblings;
    }

    /**
     * Set gallery
     *
     * @param Gallery $gallery
     *
     * @return Person
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
     * Add event
     *
     * @param Event $event
     * @return Person
     */
    public function addEvent(Event $event = null)
    {
        $this->events->add(event);
        $event->addPerson($this);

        return $this;
    }

    /**
     * Remove event
     *
     * @param Event $event
     * @return Person
     */
    public function removeEvent(Event $event = null)
    {
    	if ($this->events->contains($event)) {
    		$this->events->removeElement($event);
    		$event->removePerson($this);
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

