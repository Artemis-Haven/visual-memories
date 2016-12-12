<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Contrôleur gérant les pages publiques, principalement la page d'accueil
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
	 * @Template()
     */
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	
        return [
        	'persons' => $em->getRepository('AppBundle:Person')->findAll(),
        	'events' => $em->getRepository('AppBundle:Event')->findAll(),
        	'places' => $em->getRepository('AppBundle:Place')->findAll()
        ];
    }
}
