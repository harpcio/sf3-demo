<?php

namespace Ace\CmsBundle\Controller\Blog;

use Ace\CommonBundle\Entity\Repository\BlogRepository;
use Ace\CommonBundle\Form\CsrfType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * @Route("", service="cms.controller.blog.list")
 */
class ListController extends Controller
{
    private $formFactory;
    private $blogRepository;

    public function __construct(FormFactoryInterface $formFactory, BlogRepository $blogRepository)
    {
        $this->formFactory = $formFactory;
        $this->blogRepository = $blogRepository;
    }

    /**
     * @Route("/blog", name="cms.blog.list")
     * @Template("AceCmsBundle:Blog:list.html.twig")
     */
    public function indexAction()
    {
        $result = $this->blogRepository->findAll();
        $csrfForm = $this->formFactory->create(CsrfType::class);

        return [
            'blogs' => $result,
            'csrfForm' => $csrfForm->createView()
        ];
    }
}
