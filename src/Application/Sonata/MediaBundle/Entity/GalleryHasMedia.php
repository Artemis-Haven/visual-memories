<?php

namespace Application\Sonata\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Entity\BaseGalleryHasMedia as BaseGalleryHasMedia;

/**
 *
 * @ORM\Table(name="media__gallery_has_media")
 * @ORM\Entity()
 */
class GalleryHasMedia extends BaseGalleryHasMedia
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
    
    public function prev()
    {
    	$prev = null;
    	foreach ($this->gallery->getGalleryHasMedias() as $item) {
    		if ($item != $this && $item->getPosition() > $this->position && ($prev == null || $prev->getPosition() > $item->getPosition()))
    			$prev = $item;
    	}
    	return $prev;
    }
    
    public function next()
    {
    	$next = null;
    	foreach ($this->gallery->getGalleryHasMedias() as $item) {
    		if ($item != $this && $item->getPosition() < $this->position && ($next == null || $next->getPosition() < $item->getPosition()))
    			$next = $item;
    	}
    	return $next;
    }
}
