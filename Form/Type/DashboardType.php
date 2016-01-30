<?php

namespace MB\DashboardBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class DashboardType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, array(
            'label' => 'dashboard.title.label',
            'required' => true,
            'attr' => array(
                'placeholder' => 'dashboard.title.placeholder'
            )
        ));

        $projects = $options['projects'];
        $config = $options['config'];

        foreach ($projects as $project)
        {
            $checked = null;
            if (isset($config[$project->getId()]['commits'])) {
                $checked = true;
            }
            $builder->add('project_' . $project->getId() . '_commits', CheckboxType::class, array(
                'label' => 'dashboard.project.commits.label',
                'required' => false,
                'mapped' => false,
                'data' => $checked
            ));
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MB\DashboardBundle\Entity\Dashboard',
            'projects' => array(),
            'config' => array()
        ));
    }

    public function getName()
    {
        return '';
    }
}
