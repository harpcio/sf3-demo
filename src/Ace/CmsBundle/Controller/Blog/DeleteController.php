<?php

namespace Ace\CmsBundle\Controller\Blog;

use Ace\CommonBundle\Entity\Repository\BlogRepository;
use Ace\CommonBundle\Form\CsrfType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("", service="cms.controller.blog.delete")
 */
class DeleteController extends Controller
{
    private $formFactory;
    private $session;
    private $blogRepository;

    public function __construct(FormFactoryInterface $formFactory, Session $session, BlogRepository $blogRepository)
    {
        $this->formFactory = $formFactory;
        $this->session = $session;
        $this->blogRepository = $blogRepository;
    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @Route("/blog/{id}/delete", name="cms.blog.delete")
     *
     * @return RedirectResponse
     */
    public function indexAction(Request $request, $id)
    {
        $blog = $this->blogRepository->find($id);

        if (!$blog) {
            $this->session->getFlashBag()->add('error', 'Item was not found');

            return $this->redirectToRoute('cms.blog.list');
        }

        $csrfForm = $this->formFactory->create(CsrfType::class);
        $csrfForm->handleRequest($request);

        if ($csrfForm->isSubmitted()) {
            if ($csrfForm->isValid()) {
                $this->blogRepository->delete([$blog], true);
                $this->session->getFlashBag()->add('success', 'Item has been deleted');
            } else {
                $this->session->getFlashBag()->add(
                    'error',
                    'The csrf form had some error(s) and the item has not been deleted.'
                );
            }
        }

        return $this->redirectToRoute('cms.blog.list');
    }
}
