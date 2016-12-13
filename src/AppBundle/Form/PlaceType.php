<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlaceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
            	'label' => 'Nom'
            ])
            ->add('country', 'genemu_jqueryselect2_entity', [
            	'class' => "AppBundle\Entity\Country",
            	'label' => "Pays",
            ])
            ->add('description', 'textarea', [
            	'required' => false
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Place'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_place';
    }
}
