<?php

namespace Ace\CmsBundle\Controller\Event;

use Ace\CommonBundle\Entity\Repository\EventRepository;
use Ace\CommonBundle\Form\EventType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("", service="cms.controller.event.create")
 */
class CreateController extends Controller
{
    private $formFactory;
    private $session;
    private $eventRepository;

    public function __construct(
        FormFactoryInterface $formFactory,
        Session $session,
        EventRepository $eventRepository
    ) {
        $this->formFactory = $formFactory;
        $this->session = $session;
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param Request $request
     *
     * @Route("/event/create", name="cms.event.create")
     * @Template("AceCmsBundle:Event:create-update.html.twig")
     *
     * @return array
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        $event = $this->eventRepository->create();
        $form = $this->formFactory->create(EventType::class, $event, ['add_submit_buttons' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $event->setCreatedBy($user);

                $this->eventRepository->save([$event], true);

                $this->session->getFlashBag()->add('success', 'Item was successfully saved');

                return $this->redirectToRoute("cms.event.update", ['id' => $event->getId()]);
            } else {
                $this->session->getFlashBag()->add('error', 'The form has some error(s).');
            }
        }

        return ['form' => $form->createView()];
    }
}
