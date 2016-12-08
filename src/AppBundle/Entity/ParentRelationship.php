<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ParentRelationship
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ParentRelationship
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
     * @var Person
     * 
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="childrenRelationships")
     * @ORM\JoinColumn()
     */
    private $parent;
    
    /**
     * @var Person
     * 
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="parentsRelationships")
     * @ORM\JoinColumn()
     */
    private $child;


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
     * Set parent
     *
     * @param Person $parent
     *
     * @return ParentRelationship
     */
    public function setParent(Person $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return Person
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set child
     *
     * @param Person $child
     *
     * @return ParentRelationship
     */
    public function setChild(Person $child = null)
    {
        $this->child = $child;

        return $this;
    }

    /**
     * Get child
     *
     * @return Person
     */
    public function getChild()
    {
        return $this->child;
    }
}

