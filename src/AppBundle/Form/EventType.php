<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
            	'label' => "Nom"
            ])
            ->add('description', 'textarea', [
            	'required' => false
            ])
            ->add('startDate', null, [
            	'label' => "Date",
            	'required' => false,
	            'widget' => 'single_text',
	            'datepicker' => true,
            ])
            ->add('endDate', null, [
            	'label' => "Date de fin",
            	'required' => false,
	            'widget' => 'single_text',
	            'datepicker' => true,
            ])
            ->add('place', null, [
            	'label' => "Lieu"
            ])
            ->add('persons', 'genemu_jqueryselect2_entity', [
            	'class' => 'AppBundle\Entity\Person',
            	'multiple' => true
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Event'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_event';
    }
}
