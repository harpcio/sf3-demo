<?php

namespace Ace\CmsBundle\Controller\Blog;

use Ace\CommonBundle\Entity\Repository\BlogRepository;
use Ace\CommonBundle\Form\BlogType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("", service="cms.controller.blog.create")
 */
class CreateController extends Controller
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
     *
     * @Route("/blog/create", name="cms.blog.create")
     * @Template("AceCmsBundle:Blog:create-update.html.twig")
     *
     * @return array
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        $blog = $this->blogRepository->create();
        $form = $this->formFactory->create(BlogType::class, $blog, ['add_submit_buttons' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $blog->addNotExistedEvents();
                $blog->setCreatedBy($user);

                $this->blogRepository->save([$blog], true);

                $this->session->getFlashBag()->add('success', 'Item was successfully saved');

                return $this->redirectToRoute("cms.blog.update", ['id' => $blog->getId()]);
            } else {
                $this->session->getFlashBag()->add('error', 'The form has some error(s).');
            }
        }

        return ['form' => $form->createView()];
    }
}
