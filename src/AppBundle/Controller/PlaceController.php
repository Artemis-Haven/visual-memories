<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Place;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\PlaceType;
use Application\Sonata\MediaBundle\Entity\Gallery;

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
    
    /**
     * @Route("/new", name="place_new")
	 * @Template()
     */
    public function newAction(Request $request)
    {
    	$place = new Place();
    	$france = $this->getDoctrine()->getManager()->getRepository("AppBundle:Country")->findOneByCode('FR');
    	$place->setCountry($france);
    	
    	$form = $this->createForm(new PlaceType(), $place, [
    		'method' => 'POST',
    	]);
    	$form->add('submit', 'submit', ['label' => 'Valider']);
    	
    	$form->handleRequest($request);
    	if ($form->isValid()) {
    		$em = $this->getDoctrine()->getManager();
    		$gallery = new Gallery();
    		$gallery->setName($place->getName());
    		$gallery->setContext('person');
    		$gallery->setDefaultFormat('');
    		$gallery->setEnabled(true);
    		$place->setGallery($gallery);
    		$em->persist($place);
    		$em->persist($gallery);
    		$em->flush();
    		$this->addFlash('success', 'Vous venez de créer un nouvel événement !');
    		
    		return $this->redirectToRoute('place_show', ['id' => $place->getId()]);
    	}
    	
        return [
        	'form' => $form->createView(),
        	'place' => $place
        ];
    }
    
    /**
     * @Route("/edit-{id}", name="place_edit")
	 * @ParamConverter("place", class="AppBundle:Place")
	 * @Template()
     */
    public function editAction(Place $place, Request $request)
    {
    	$form = $this->createForm(new PlaceType(), $place, [
    		'method' => 'POST',
    	]);
    	$form->add('submit', 'submit', ['label' => 'Valider']);
    	
    	$form->handleRequest($request);
    	if ($form->isValid()) {
    		$em = $this->getDoctrine()->getManager();
    		$em->flush();
    		$this->addFlash('success', 'Modification enregistrées.');
    		return $this->redirectToRoute('place_show', ['id' => $place->getId()]);
    	}
    	
        return [
        	'form' => $form->createView(),
        	'place' => $place
        ];
    }
}
