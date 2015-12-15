<?php

namespace Ace\AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="app.homepage")
     * @Template("AceAppBundle:Default:index.html.twig")
     */
    public function indexAction()
    {
        return [];
    }
}
