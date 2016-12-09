<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Event;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Contrôleur gérant les pages liées à l'entité Event : création, consultation, modification, suppression
 * @Route("/event")
 */
class EventController extends Controller
{
    /**
     * @Route("/fiche-{id}", name="event_show")
	 * @ParamConverter("event", class="AppBundle:Event")
	 * @Template()
     */
    public function showAction(Event $event)
    {
        return [
        	'event' => $event
        ];
    }
}
