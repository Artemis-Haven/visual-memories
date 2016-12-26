<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Contrôleur gérant les pages publiques, principalement la page d'accueil
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
	    if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
	    	$em = $this->getDoctrine()->getManager();
	    	
	        return new Response($this->renderView('AppBundle:Default:index.html.twig', [
	        	'persons' => $em->getRepository('AppBundle:Person')->findAll(),
	        	'events' => $em->getRepository('AppBundle:Event')->findAll(),
	        	'places' => $em->getRepository('AppBundle:Place')->findAll()
	        ]));
		} else {
			return new Response($this->renderView('AppBundle:Default:publicIndex.html.twig'));
		}
    }
}
