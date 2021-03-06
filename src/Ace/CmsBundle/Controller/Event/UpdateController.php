<?php

namespace Ace\CmsBundle\Controller\Event;

use Ace\CmsBundle\Service;
use Ace\CommonBundle\Entity;
use Ace\CommonBundle\Entity\Repository\EventRepository;
use Ace\CommonBundle\Form\EventType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("", service="cms.controller.event.update")
 */
class UpdateController extends Controller
{
    private $formFactory;
    private $session;
    private $eventRepository;
    private $createUpdateService;

    public function __construct(
        FormFactoryInterface $formFactory,
        Session $session,
        EventRepository $eventRepository,
        Service\Event\CreateUpdate $createUpdateService
    ) {
        $this->formFactory = $formFactory;
        $this->session = $session;
        $this->eventRepository = $eventRepository;
        $this->createUpdateService = $createUpdateService;
    }

    /**
     * @param Request $request
     * @param integer $id
     *
     * @Route("/event/{id}/update", name="cms.event.update")
     * @Template("AceCmsBundle:Event:create-update.html.twig")
     *
     * @return array
     */
    public function indexAction(Request $request, $id)
    {
        /** @var Entity\Event $event */
        $event = $this->eventRepository->find($id);

        if (!$event) {
            $this->session->getFlashBag()->add('error', 'Item was not found');

            return $this->redirectToRoute('cms.event.list');
        }

        $form = $this->formFactory->create(EventType::class, $event, ['add_submit_buttons' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->createUpdateService->handle($event);
                $this->eventRepository->save([$event], true);

                $this->session->getFlashBag()->add('success', 'Item was successfully saved.');
            } else {
                $this->session->getFlashBag()->add('error', 'The form has some error(s).');
            }
        }

        return ['form' => $form->createView()];
    }
}
