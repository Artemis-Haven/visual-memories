<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Event;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Application\Sonata\MediaBundle\Entity\Gallery;
use AppBundle\Form\EventType;

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
    
    /**
     * @Route("/new", name="event_new")
	 * @Template()
     */
    public function newAction(Request $request)
    {
    	$event = new Event();
    	$form = $this->createForm(new EventType(), $event, [
    		'method' => 'POST',
    	]);
    	$form->add('submit', 'submit', ['label' => 'Valider']);
    	
    	$form->handleRequest($request);
    	if ($form->isValid()) {
    		$em = $this->getDoctrine()->getManager();
    		$gallery = new Gallery();
    		$gallery->setName($event->getName());
    		$gallery->setContext('person');
    		$gallery->setDefaultFormat('');
    		$gallery->setEnabled(true);
    		$event->setGallery($gallery);
    		$em->persist($event);
    		$em->persist($gallery);
    		$em->flush();
    		$this->addFlash('success', 'Vous venez de créer un nouvel événement !');
    		
    		return $this->redirectToRoute('event_show', ['id' => $event->getId()]);
    	}
    	
        return [
        	'form' => $form->createView(),
        	'event' => $event
        ];
    }
    
    /**
     * @Route("/edit-{id}", name="event_edit")
	 * @ParamConverter("event", class="AppBundle:Event")
	 * @Template()
     */
    public function editAction(Event $event, Request $request)
    {
    	$form = $this->createForm(new EventType(), $event, [
    		'method' => 'POST',
    	]);
    	$form->add('submit', 'submit', ['label' => 'Valider']);
    	
    	$form->handleRequest($request);
    	if ($form->isValid()) {
    		$em = $this->getDoctrine()->getManager();
    		$em->flush();
    		$this->addFlash('success', 'Modification enregistrées.');
    		return $this->redirectToRoute('event_show', ['id' => $event->getId()]);
    	}
    	
        return [
        	'form' => $form->createView(),
        	'event' => $event
        ];
    }
}
