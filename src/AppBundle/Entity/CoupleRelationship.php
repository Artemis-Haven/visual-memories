<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoupleRelationship
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class CoupleRelationship
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
   	const TYPE_MARRIAGE = "Mariage";
   	const TYPE_FREE_UNION = "Union libre";
   	const TYPE_PACS = "PACS";

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;
    
    /**
     * @var Person
     * 
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="firstCoupleRelationships")
     * @ORM\JoinColumn()
     */
    private $person1;
    
    /**
     * @var Person
     * 
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="secondCoupleRelationships")
     * @ORM\JoinColumn()
     */
    private $person2;


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
     * Set type
     *
     * @param string $type
     *
     * @return CoupleRelationship
     */
    public function setType($type)
    {
    	if (in_array($type, self::getTypesList()))
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
    
    public static function getTypesList()
    {
    	$list = [self::TYPE_MARRIAGE, self::TYPE_FREE_UNION, self::TYPE_PACS];
    	return array_combine($list,	$list);
    }

    /**
     * Set person1
     *
     * @param Person $person1
     *
     * @return CoupleRelationship
     */
    public function setPerson1(Person $person1 = null)
    {
        $this->person1 = $person1;

        return $this;
    }

    /**
     * Get person1
     *
     * @return Person
     */
    public function getPerson1()
    {
        return $this->person1;
    }

    /**
     * Set person2
     *
     * @param Person $person2
     *
     * @return CoupleRelationship
     */
    public function setPerson2(Person $person2 = null)
    {
        $this->person2 = $person2;

        return $this;
    }

    /**
     * Get person2
     *
     * @return Person
     */
    public function getPerson2()
    {
        return $this->person2;
    }
}

