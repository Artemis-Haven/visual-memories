<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Person;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\PersonType;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Application\Sonata\MediaBundle\Form\GalleryType;

/**
 * Contrôleur gérant les pages liées à l'entité Person : création, consultation, modification, suppression
 * 
 * @Route("/pers")
 */
class PersonController extends Controller
{
    /**
     * @Route("/fiche-{id}", name="person_show")
	 * @ParamConverter("person", class="AppBundle:Person")
	 * @Template()
     */
    public function showAction(Person $person)
    {
        return [
        	'person' => $person
        ];
    }
    
    /**
     * @Route("/new", name="person_new")
	 * @Template()
     */
    public function newAction(Request $request)
    {
    	$person = new Person();
    	$form = $this->createForm(new PersonType(), $person, [
    		'method' => 'POST',
    	]);
    	$form->add('submit', 'submit', ['label' => 'Valider']);
    	
    	$form->handleRequest($request);
    	if ($form->isValid()) {
    		$em = $this->getDoctrine()->getManager();
    		$gallery = new Gallery();
    		$gallery->setName('Galerie de '.$person->getFirstName().' '.$person->getLastName());
    		$gallery->setContext('person');
    		$gallery->setDefaultFormat('');
    		$gallery->setEnabled(true);
    		$person->setGallery($gallery);
    		$em->persist($person);
    		$em->persist($gallery);
    		$em->flush();
    		$this->addFlash('success', 'Vous venez de créer une nouvelle personne !');
    		
    		return $this->redirectToRoute('person_show', ['id' => $person->getId()]);
    	}
    	
        return [
        	'form' => $form->createView(),
        	'person' => $person
        ];
    }
    
    /**
     * @Route("/edit-{id}", name="person_edit", requirements={"id"="\d+"})
	 * @ParamConverter("person", class="AppBundle:Person")
	 * @Template()
     */
    public function editAction(Person $person, Request $request)
    {
    	$form = $this->createForm(new PersonType(), $person, [
    		'method' => 'POST',
    	]);
    	$form->add('submit', 'submit', ['label' => 'Valider']);
    	
    	$form->handleRequest($request);
    	if ($form->isValid()) {
    		$em = $this->getDoctrine()->getManager();
    		$em->flush();
    		$this->addFlash('success', 'Modification enregistrées.');
    		return $this->redirectToRoute('person_show', ['id' => $person->getId()]);
    	}
    	
        return [
        	'form' => $form->createView(),
        	'person' => $person
        ];
    }
}
