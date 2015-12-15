<?php

namespace Ace\AppBundle\Controller\Blog;

use Ace\CommonBundle\Entity\Blog;
use Ace\CommonBundle\Entity\Repository\BlogRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("", service="app.controller.blog.show")
 */
class ShowController extends Controller
{
    private $session;
    private $blogRepository;

    public function __construct(Session $session, BlogRepository $blogRepository)
    {
        $this->session = $session;
        $this->blogRepository = $blogRepository;
    }

    /**
     * @param int $id
     * @Route("/blog/{id}", name="app.blog.show")
     * @Template("AceAppBundle:Blog:show.html.twig")
     *
     * @return array
     */
    public function indexAction($id)
    {
        /** @var Blog $blog */
        $blog = $this->blogRepository->find($id);

        if (!$blog) {
            $this->session->getFlashBag()->add('error', 'Item was not found');

            return $this->redirectToRoute('app.blog.list');
        }

        return [
            'blog' => $blog
        ];
    }
}
