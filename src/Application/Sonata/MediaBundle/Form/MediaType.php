<?php

namespace Application\Sonata\MediaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MediaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('name', 'text', [
        		'label' => "Titre de la photo"
        	])
            ->add('description')
            ->add('persons', 'genemu_jqueryselect2_entity', [
            	'class' => 'AppBundle:Person',
            	'label' => 'Personnes',
            	'required' => false,
            	'multiple' => true,
            	'mapped' => false
            ])
            ->add('event', 'genemu_jqueryselect2_entity', [
            	'class' => 'AppBundle:Event',
            	'label' => 'Evénement',
            	'required' => false,
            	'multiple' => false,
            	'mapped' => false,
            	'placeholder' => "Aucun événement particulier"
            ])
            ->add('place', 'genemu_jqueryselect2_entity', [
            	'class' => 'AppBundle:Place',
            	'label' => 'Lieu',
            	'required' => false,
            	'multiple' => false,
            	'mapped' => false,
            	'placeholder' => "Aucun lieu particulier"
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\Sonata\MediaBundle\Entity\Media'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'application_sonata_mediabundle_media';
    }
}
