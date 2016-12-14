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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\ParentRelationship;
use AppBundle\Entity\CoupleRelationship;

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
    	$newRelationForm = $this->createNewRelationForm($person);
    	
        return [
        	'person' => $person,
        	'newRelationForm' => $newRelationForm->createView()
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
    
    private function createNewRelationForm(Person $person)
    {
    	$builder = $this->createFormBuilder()
    		->setAction($this->generateUrl('person_add_relation', ['id' => $person->getId()]))
    		->add('relation', 'genemu_jqueryselect2_choice', [
    			'choices' => ['parent' => "Parent", 'couple' => "Couple", 'child' => "Enfant"],
    		])
    		->add('person', 'genemu_jqueryselect2_entity', [
    			'class' => "AppBundle\Entity\Person",
    			'label' => "Personne"
    		])
    		->add('coupleType', 'genemu_jqueryselect2_choice', [
    			'choices' => CoupleRelationship::getTypesList(),
    			'label' => "Type d'union"
    		])
    		->add('submit', 'submit', ['label' => "Valider"])
    	;
    	return $builder->getForm();
    }
    
    /**
     * @Route("/add-relation-{id}", name="person_add_relation", requirements={"id"="\d+"})
	 * @ParamConverter("person", class="AppBundle:Person")
	 * @Method("POST")
	 * @Template()
     */
    public function addRelationAction(Person $person, Request $request)
    {
    	$form = $this->createNewRelationForm($person);
    	
    	$form->handleRequest($request);
    	
    	if ($form->isValid()) {
    		$em = $this->getDoctrine()->getManager();
    		$otherPerson = $form->get('person')->getData();
    		if ($form->get('relation')->getData() == 'parent') {
    			$rel = new ParentRelationship();
    			$rel->setChild($person);
    			$rel->setParent($otherPerson);
    			$em->persist($rel);
    		} else if ($form->get('relation')->getData() == 'child') {
    			$rel = new ParentRelationship();
    			$rel->setParent($person);
    			$rel->setChild($otherPerson);
    			$em->persist($rel);
    		} else if ($form->get('relation')->getData() == 'couple') {
    			$rel = new CoupleRelationship();
    			$rel->setPerson1($person);
    			$rel->setPerson2($otherPerson);
    			$rel->setType($form->get('coupleType')->getData());
    			$em->persist($rel);
    		}
    		$em->flush();
    		$this->addFlash('success', 'La relation entre '.$person.' et '.$otherPerson.' a bien été ajoutée.');
    	}
    	
        return $this->redirectToRoute('person_show', ['id' => $person->getId()]);
    }
    
    /**
     * @Route("/remove-couple-relation-{id}", name="person_remove_couple_relation", requirements={"id"="\d+"})
	 * @ParamConverter("relation", class="AppBundle:CoupleRelationship")
	 * @Template()
     */
    public function removeCoupleRelationAction(CoupleRelationship $relation)
    {
   		$em = $this->getDoctrine()->getManager();
   		$em->remove($relation);
   		$em->flush();
   		$this->addFlash('success', 'La relation entre '.$relation->getPerson1().' et '.$relation->getPerson2().' a bien été supprimée.');


   		$referer = $this->getRequest()->headers->get('referer');
   		if (strlen($referer) == 0) {
        	return $this->redirectToRoute('person_show', ['id' => $relation->getPerson1()->getId()]);
   		} else {
   			return $this->redirect($referer);
   		}
    }
    
    /**
     * @Route("/remove-parent-relation-{id}", name="person_remove_parent_relation", requirements={"id"="\d+"})
	 * @ParamConverter("relation", class="AppBundle:ParentRelationship")
	 * @Template()
     */
    public function removeParentRelationAction(ParentRelationship $relation)
    {
   		$em = $this->getDoctrine()->getManager();
   		$em->remove($relation);
   		$em->flush();
   		$this->addFlash('success', 'La relation entre '.$relation->getParent().' et '.$relation->getChild().' a bien été supprimée.');


   		$referer = $this->getRequest()->headers->get('referer');
   		if (strlen($referer) == 0) {
        	return $this->redirectToRoute('person_show', ['id' => $relation->getParent()->getId()]);
   		} else {
   			return $this->redirect($referer);
   		}
    }
}
