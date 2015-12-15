<?php

namespace Ace\CmsBundle\Controller\Event;

use Ace\CommonBundle\Entity\Repository\EventRepository;
use Ace\CommonBundle\Form\CsrfType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * @Route("", service="cms.controller.event.list")
 */
class ListController extends Controller
{
    private $formFactory;
    private $eventRepository;

    public function __construct(FormFactoryInterface $formFactory, EventRepository $eventRepository)
    {
        $this->formFactory = $formFactory;
        $this->eventRepository = $eventRepository;
    }

    /**
     * @Route("/event", name="cms.event.list")
     * @Template("AceCmsBundle:Event:list.html.twig")
     */
    public function indexAction()
    {
        $result = $this->eventRepository->findAll();
        $csrfForm = $this->formFactory->create(CsrfType::class);

        return [
            'events' => $result,
            'csrfForm' => $csrfForm->createView()
        ];
    }
}
