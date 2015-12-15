<?php

namespace Ace\CmsBundle\Controller\Event;

use Ace\CommonBundle\Entity\Repository\EventRepository;
use Ace\CommonBundle\Form\CsrfType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("", service="cms.controller.event.delete")
 */
class DeleteController extends Controller
{
    private $formFactory;
    private $session;
    private $eventRepository;

    public function __construct(FormFactoryInterface $formFactory, Session $session, EventRepository $eventRepository)
    {
        $this->formFactory = $formFactory;
        $this->session = $session;
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @Route("/event/{id}/delete", name="cms.event.delete")
     *
     * @return RedirectResponse
     */
    public function indexAction(Request $request, $id)
    {
        $event = $this->eventRepository->find($id);

        if (!$event) {
            $this->session->getFlashBag()->add('error', 'Item was not found');

            return $this->redirectToRoute('cms.event.list');
        }

        $csrfForm = $this->formFactory->create(CsrfType::class);
        $csrfForm->handleRequest($request);

        if ($csrfForm->isSubmitted()) {
            if ($csrfForm->isValid()) {
                $this->eventRepository->delete([$event], true);
                $this->session->getFlashBag()->add('success', 'Item has been deleted');
            } else {
                $this->session->getFlashBag()->add(
                    'error',
                    'The csrf form had some error(s) and the item has not been deleted.'
                );
            }
        }

        return $this->redirectToRoute('cms.event.list');
    }
}
