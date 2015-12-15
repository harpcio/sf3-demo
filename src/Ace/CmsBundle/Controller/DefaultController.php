<?php

namespace Ace\CmsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="cms.homepage")
     * @Template("AceCmsBundle:Default:index.html.twig")
     */
    public function indexAction()
    {
        return [];
    }
}
