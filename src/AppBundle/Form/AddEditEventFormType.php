<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AddEditEventFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title', null, array('label' => 'label.title'))
            ->add('startTime', null, array('label' => 'label.startTime'))
            ->add('endTime', null, array('label' => 'label.endTime'))
            ->add('startDate', "hidden", array('label' => 'label.startDate'))
            ->add('endDate', "hidden", array('label' => 'label.endDate'))
            ->add('description', 'textarea', array('label' => 'label.description'));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        return array(
            'csrf_protection' => false
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_event';
    }
}
