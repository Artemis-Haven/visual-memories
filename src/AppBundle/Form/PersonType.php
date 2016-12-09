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
            ->add('birthDate', null, [
            	'label' => "Date de naissance",
            	'required' => false
            ])
            ->add('deathDate', null, [
            	'label' => "Date de décès",
            	'required' => false
            ])
            ->add('sex', 'choice', [
            	'label' => "Sexe",
            	'choices' => [Person::SEX_FEMALE => Person::SEX_FEMALE, Person::SEX_MALE => Person::SEX_MALE],
            	'required' => false
            ])
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
