<?php

namespace Bdtln\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType;
use Bdtln\UserBundle\Form\PhotoType;

class UserProfileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
                
                //Translations for label below are in Bdtln/UserBundle/Resources/translations/
            ->add('firstName', 'text', array('label' => "form.firstname", 'translation_domain' => 'FOSUserBundle'))
            ->add('lastName', 'text', array('label' => "form.lastname", 'translation_domain' => 'FOSUserBundle'))
            ->add('frenchBiography', 'textarea', array('label' => 'form.frenchbiography', 'translation_domain' => 'FOSUserBundle', 'required' => false) )
            ->add('englishBiography', 'textarea', array('label' => 'form.englishbiography', 'translation_domain' => 'FOSUserBundle', 'required' => false) )
            ->add('photo', new PhotoType(), array('label' => "Photo", "required" => false))
                
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bdtln\UserBundle\Entity\User'
        ));
    }
    
    
    

    /**
     * @return string
     */
    public function getName()
    {
        return 'bdtln_userbundle_user';
    }
}
