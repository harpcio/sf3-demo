<?php

namespace Ace\CommonBundle\Form;

use Ace\CommonBundle\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    private $uploadPath;

    public function __construct($uploadPath)
    {
        $this->uploadPath = $uploadPath;
    }

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
            ->add('start')
            ->add('end')
            ->add('blogs')
            ->add(
                'brochure',
                Type\FileType::class,
                [
                    'label' => 'Brochure (PDF)',
                    'required' => false
                ]
            );

        if ($options['add_submit_buttons']) {
            $builder->add('submit', Type\SubmitType::class);
        }

        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData']);
    }

    public function onPreSetData(FormEvent $e)
    {
        /** @var Entity\Event $event */
        $event = $e->getData();

        if ($event->getBrochure()) {
            $uploadedFile = new UploadedFile(
                $this->uploadPath.DIRECTORY_SEPARATOR.$event->getBrochure(),
                $event->getBrochure()
            );
            $event->setBrochure($uploadedFile);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Entity\Event::class,
                'add_submit_buttons' => false,
                'csrf_protection' => true
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ace_common_event_type';
    }
}
