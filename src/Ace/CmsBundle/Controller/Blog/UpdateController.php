<?php

namespace Ace\CmsBundle\Controller\Blog;

use Ace\CommonBundle\Entity\Blog;
use Ace\CommonBundle\Entity\Event;
use Ace\CommonBundle\Entity\Repository\BlogRepository;
use Ace\CommonBundle\Entity\Repository\EventRepository;
use Ace\CommonBundle\Form\BlogType;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("", service="cms.controller.blog.update")
 */
class UpdateController extends Controller
{
    private $formFactory;
    private $session;
    private $blogRepository;

    public function __construct(
        FormFactoryInterface $formFactory,
        Session $session,
        BlogRepository $blogRepository
    ) {
        $this->formFactory = $formFactory;
        $this->session = $session;
        $this->blogRepository = $blogRepository;
    }

    /**
     * @param Request $request
     * @param integer $id
     *
     * @Route("/blog/{id}/update", name="cms.blog.update")
     * @Template("AceCmsBundle:Blog:create-update.html.twig")
     *
     * @return array
     */
    public function indexAction(Request $request, $id)
    {
        /** @var Blog $blog */
        $blog = $this->blogRepository->find($id);

        if (!$blog) {
            $this->session->getFlashBag()->add('error', 'Item was not found');

            return $this->redirectToRoute('cms.blog.list');
        }

        $originalEvents = new ArrayCollection();
        foreach ($blog->getEvents() as $event) {
            $originalEvents->add($event);
        }

        $form = $this->formFactory->create(BlogType::class, $blog, ['add_submit_buttons' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $blog->addNotExistedEvents();
                $blog->removeNotExistedEvents($originalEvents);

                $this->blogRepository->save([$blog], true);

                $this->session->getFlashBag()->add('success', 'Item was successfully saved');
            } else {
                $this->session->getFlashBag()->add('error', 'The form has some error(s).');
            }
        }

        return ['form' => $form->createView()];
    }
}
