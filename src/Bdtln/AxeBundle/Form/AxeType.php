<?php

namespace Bdtln\AxeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AxeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('frenchTitle', 'text')
            ->add('englishTitle', 'text')
            ->add('englishDescription', 'textarea', array('required' => false))
            ->add('frenchDescription', 'textarea', array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bdtln\AxeBundle\Entity\Axe'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bdtln_axebundle_axe';
    }
}
