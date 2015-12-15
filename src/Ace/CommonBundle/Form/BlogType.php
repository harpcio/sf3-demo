<?php

namespace Ace\CommonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlogType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('intro')
            ->add('content')
            ->add('events');

        if ($options['add_submit_buttons']) {
            $builder->add('submit', SubmitType::class);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Ace\CommonBundle\Entity\Blog',
                'add_submit_buttons' => false
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ace_common_blog';
    }
}
