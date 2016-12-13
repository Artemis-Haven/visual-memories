<?php

namespace Application\Sonata\MediaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Person;
use Symfony\Component\HttpFoundation\Request;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Application\Sonata\MediaBundle\Form\GalleryType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Application\Sonata\MediaBundle\Entity\Media;
use Application\Sonata\MediaBundle\Entity\GalleryHasMedia;

/**
 * Contrôleur gérant les pages liées à l'entité Person : création, consultation, modification, suppression
 * 
 * @Route("/gallery")
 */
class GalleryController extends Controller
{
    /**
     * @Route("-{id}", name="gallery_show", requirements={"id"="\d+"})
	 * @ParamConverter("gallery", class="ApplicationSonataMediaBundle:Gallery")
	 * @Template()
     */
    public function showAction(Gallery $gallery)
    {
        return [
        	'gallery' => $gallery
        ];
    }
   
    /**
     * @Route("/edit-{id}", name="gallery_edit", requirements={"id"="\d+"})
	 * @ParamConverter("gallery", class="ApplicationSonataMediaBundle:Gallery")
	 * @Template()
     */
    public function editAction(Gallery $gallery, Request $request)
    {
    	$form = $this->createForm(new GalleryType(), $gallery, [
    		'method' => 'POST',
    	]);
    	$form->add('submit', 'submit', ['label' => 'Valider']);
    	
    	$form->handleRequest($request);
    	if ($form->isValid()) {
    		$em = $this->getDoctrine()->getManager();
    		$em->flush();
    		$this->addFlash('success', 'Modification enregistrées.');
    		return $this->redirectToRoute('gallery_show', ['id' => $gallery->getId()]);
    	}
    	
        return [
        	'form' => $form->createView(),
        	'gallery' => $gallery
        ];
    }
   
    /**
     * @Route("/add-photos-{id}", name="gallery_add_photos", requirements={"id"="\d+"})
	 * @ParamConverter("gallery", class="ApplicationSonataMediaBundle:Gallery")
	 * @Template()
     */
    public function addPhotosAction(Gallery $gallery, Request $request)
    {
    	
    	
        return [
        	'gallery' => $gallery
        ];
    }
   
    /**
     * @Route("/file-upload-{id}", name="gallery_file_upload", requirements={"id"="\d+"})
	 * @ParamConverter("gallery", class="ApplicationSonataMediaBundle:Gallery")
	 * @Method("POST")
     */
    public function fileUploadAction(Gallery $gallery, Request $request)
    {
    	if (!$request->isXmlHttpRequest()) {
    		return new JsonResponse(array('message' => 'You can access this only using Ajax!'), 400);
    	}
    	
    	$mediaManager = $this->container->get('sonata.media.manager.media');
    	
    	$files = $request->files->get('files');
    	$res = ['files' => []];
    	foreach ($files as $file) {
    		$media = new Media();
    		$ghm = new GalleryHasMedia();
	    	$media->setBinaryContent($file);
	    	if (in_array(strtolower($media->getBinaryContent()->getMimeType()), ['image/pjpeg', 'image/jpeg', 'image/png', 'image/x-png'])) {
	    		$media->setProviderName('sonata.media.provider.image');
	    		$media->setContext(1);
	    		$ghm->setMedia($media);
	    		$ghm->setGallery($gallery);
	    		$this->getDoctrine()->getManager()->persist($ghm);
	    		$mediaManager->save($media);
	    		$res['files'][] = [
	    			'name' => $media->getName(),
	    			'size' => $media->getSize(),
	    			'url' => $this->container->get('sonata.media.provider.image')->generatePublicUrl($media, 'reference'),
	    			'thumbnailUrl' => $this->container->get('sonata.media.twig.extension')->path($media, 'small'),
	    			'deleteUrl' => $this->generateUrl('gallery_file_delete', ['id' => $media->getId()]),
	    			'deleteType' => "DELETE"
	    		];
	    	} else {
	    		$res['files'][] = [
	    			'name' => $media->getName(),
	    			'size' => $media->getSize(),
	    			'error' => "Format de fichier non autorisé"
	    		];
	    	}
    	}
    	
        return new Response(json_encode($res));
    }
   
    /**
     * @Route("/file-delete-{id}", name="gallery_file_delete", requirements={"id"="\d+"})
	 * @ParamConverter("media", class="ApplicationSonataMediaBundle:Media")
	 * @Method("DELETE")
     */
    public function fileDeleteAction(Media $media, Request $request)
    {
    	if (!$request->isXmlHttpRequest()) {
    		return new JsonResponse(array('message' => 'You can access this only using Ajax!'), 400);
    	}
    	
    	$mediaManager = $this->container->get('sonata.media.manager.media');
    	$mediaManager->delete($media, true);
    	
    	$res = ['files' => [$media->getName() => true]];
    	
        return new Response(json_encode($res));
    }
}
