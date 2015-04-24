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
            ->add('frenchTitle')
            ->add('englishTitle')
            ->add('englishDescription')
            ->add('frenchDescription')
            ->add('frenchSummary')
            ->add('englishSummary')
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
