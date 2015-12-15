<?php

namespace Ace\CommonBundle\Menu;

use Ace\CommonBundle\Entity\Repository\BlogRepository;
use Ace\CommonBundle\Security\Menu\AccessFilter;
use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Builder
{
    private $menu;
    private $factory;
    private $blogRepository;
    private $accessFilter;
    private $requestStack;

    public function __construct(
        FactoryInterface $factory,
        BlogRepository $blogRepository,
        AccessFilter $accessFilter,
        RequestStack $requestStack
    ) {
        $this->factory = $factory;
        $this->blogRepository = $blogRepository;
        $this->accessFilter = $accessFilter;
        $this->requestStack = $requestStack;
    }

    private function createMenu(array $options)
    {
        $id = $this->requestStack->getMasterRequest()->get('id', 0);

        $menu = $this->factory->createItem('root');

        /**
         * APP / Homepage
         */
        $menu->addChild('Home', ['route' => 'app.homepage']);

        /**
         * APP / Blog list
         */
        $appBlog = $menu->addChild('Blog list', ['route' => 'app.blog.list']);
        $appBlog->addChild(
            'Show',
            [
                'route' => 'app.blog.show',
                'routeParameters' => ['id' => $id],
                'display' => false
            ]
        );

        $blog = $this->blogRepository->findLast();

        if ($blog) {
            $appBlog->addChild(
                'Latest Blog Post',
                [
                    'route' => 'app.blog.show',
                    'routeParameters' => ['id' => $blog->getId()]
                ]
            );
        }

        /**
         * CMS
         */
        $cms = $menu->addChild('Cms', ['route' => 'cms.homepage']);

        /**
         * CMS / Blog
         */
        $cmsBlog = $cms->addChild('Blog list', ['route' => 'cms.blog.list']);
        $cmsBlog->addChild('Create', ['route' => 'cms.blog.create', 'display' => false]);
        $cmsBlog->addChild(
            'Update',
            ['route' => 'cms.blog.update', 'routeParameters' => ['id' => $id], 'display' => false]
        );
        $cmsBlog->addChild(
            'Delete',
            ['route' => 'cms.blog.delete', 'routeParameters' => ['id' => $id], 'display' => false]
        );

        /**
         * CMS / Event
         */
        $cmsEvent = $cms->addChild('Event list', ['route' => 'cms.event.list']);
        $cmsEvent->addChild('Create', ['route' => 'cms.event.create', 'display' => false]);
        $cmsEvent->addChild(
            'Update',
            ['route' => 'cms.event.update', 'routeParameters' => ['id' => $id], 'display' => false]
        );
        $cmsEvent->addChild(
            'Delete',
            ['route' => 'cms.event.delete', 'routeParameters' => ['id' => $id], 'display' => false]
        );

        $this->accessFilter->apply($menu);

        return $menu;
    }

    public function mainMenu(array $options)
    {
        if (!$this->menu) {
            $this->menu = $this->createMenu($options);
        }

        foreach ($this->menu->getChildren() as $item) {
            $item->setDisplayChildren(true);
        }

        return $this->menu;
    }

    public function navMenu(array $options)
    {
        if (!$this->menu) {
            $this->menu = $this->createMenu($options);
        }

        $menu = clone $this->menu;
        $menu->setChildrenAttributes(['class' => 'nav navbar-nav']);

        foreach ($menu->getChildren() as $item) {
            $item->setDisplayChildren(false);
        }

        return $menu;
    }
}