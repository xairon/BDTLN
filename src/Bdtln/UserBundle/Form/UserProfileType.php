<?php

namespace Bdtln\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType;

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
                ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
                //Translations for label below are in Bdtln/UserBundle/Resources/translations/
            ->add('firstName', 'text', array('label' => "form.firstname", 'translation_domain' => 'FOSUserBundle'))
            ->add('lastName', 'text', array('label' => "form.lastname", 'translation_domain' => 'FOSUserBundle'))
            ->add('frenchBiography', 'textarea', array('label' => 'form.frenchbiography', 'translation_domain' => 'FOSUserBundle') )
            ->add('englishBiography', 'textarea', array('label' => 'form.englishbiography', 'translation_domain' => 'FOSUserBundle') )
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
