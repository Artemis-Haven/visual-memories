<?php

namespace Application\Sonata\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Entity\BaseMedia as BaseMedia;

/**
 *
 * @ORM\Table(name="media__media")
 * @ORM\Entity()
 */
class Media extends BaseMedia
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
     * Get id
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function getPersons()
    {
    	$persons = [];
    	foreach ($this->getGalleryHasMedias() as $galleryItem) {
    		if ($galleryItem->getGallery()->getPerson())
    			$persons[] = $galleryItem->getGallery()->getPerson();
    	}
    	return $persons;
    }
    
    public function getEvent()
    {
    	foreach ($this->getGalleryHasMedias() as $galleryItem) {
    		if ($galleryItem->getGallery()->getEvent())
    			return $galleryItem->getGallery()->getEvent();
    	}
    }
    
    public function getPlace()
    {
    	foreach ($this->getGalleryHasMedias() as $galleryItem) {
    		if ($galleryItem->getGallery()->getPlace())
    			return $galleryItem->getGallery()->getPlace();
    	}
    }
}
