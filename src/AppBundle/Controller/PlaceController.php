<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Place;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Contrôleur gérant les pages liées à l'entité Place : création, consultation, modification, suppression
 * @Route("/place")
 */
class PlaceController extends Controller
{
    /**
     * @Route("/fiche-{id}", name="place_show")
	 * @ParamConverter("place", class="AppBundle:Place")
	 * @Template()
     */
    public function showAction(Place $place)
    {
        return [
        	'place' => $place
        ];
    }
}
