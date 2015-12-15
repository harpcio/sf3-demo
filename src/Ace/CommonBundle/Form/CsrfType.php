<?php

namespace Ace\CommonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CsrfType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Submit',
                    'attr' => [
                        'class' => 'btn btn-primary'
                    ]
                ]
            )
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'csrf_form';
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'csrf_protection' => true
            ]
        );
    }

}