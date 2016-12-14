<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\Person;

class PersonType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', 'text', [
            	'label' => "Prénom"
            ])
            ->add('middleName', 'text', [
            	'label' => "Autres prénoms",
            	'required' => false
            ])
            ->add('maidenName', 'text', [
            	'label' => "Nom de naissance",
            	'required' => false
            ])
            ->add('lastName', 'text', [
            	'label' => "Nom de famille"
            ])
            ->add('gender', 'choice', [
            	'label' => "Sexe",
            	'choices' => [Person::GENDER_FEMALE => Person::GENDER_FEMALE, Person::GENDER_MALE => Person::GENDER_MALE],
            	'required' => false
            ])
            ->add('birthDate', null, [
            	'label' => "Date de naissance",
            	'required' => false,
	            'widget' => 'single_text',
	            'datepicker' => true,
            	'widget_reset_icon' => true
            ])
            ->add('deathDate', null, [
            	'label' => "Date de décès",
            	'required' => false,
	            'widget' => 'single_text',
	            'datepicker' => true,
            	'widget_reset_icon' => true
            ])
            ->add('notes', 'textarea', [
            	'label' => "Notes",
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
            'data_class' => 'AppBundle\Entity\Person'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_person';
    }
}
