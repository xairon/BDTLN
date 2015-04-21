<?php

namespace Bdtln\ProjectBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Bdtln\ProjectBundle\Form\FileType;

class ProjectType extends AbstractType
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
            ->add('frenchSummary', 'text')
            ->add('englishSummary', 'text')
            ->add('frenchDescription', 'textarea', array('required' => false))
            ->add('englishDescription', 'textarea', array('required' => false))
            ->add('beginningDate', 'date')
            ->add('endingDate', 'date', array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bdtln\ProjectBundle\Entity\Project'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bdtln_projectbundle_project';
    }
}
