<?php

namespace Ace\CommonBundle\Security\Menu;

use Ace\CommonBundle\Security\RouteAcl;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class AccessFilter
{
    private $authorizationChecker;
    private $routeAcl;

    public function __construct(AuthorizationChecker $authorizationChecker, RouteAcl $routeAcl)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->routeAcl = $routeAcl;
    }

    public function apply($getMenu)
    {
        $this->processMenuItem($getMenu);
    }

    private function processMenuItem(ItemInterface $menu)
    {
        $uri = $menu->getUri();
        if (!empty($uri) || $uri !== '#') {
            if (false === $this->hasAccess($uri)) {
                $menu->getParent()->removeChild($menu);

                return;
            }
        }
        if ($menu->hasChildren()) {
            foreach ($menu->getChildren() as $item) {
                $this->processMenuItem($item);
            }
        }
        if ((empty($uri) || $uri === '#') && $menu->getName() !== 'root' && !$menu->hasChildren()) {
            $menu->getParent()->removeChild($menu);
        }
    }

    /**
     * @param string $uri
     *
     * @return bool
     */
    private function hasAccess($uri = "")
    {
        $roles = $this->routeAcl->getRoles($uri);
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->authorizationChecker->isGranted($role)) {
                    return true;
                }
            }
        }

        return false;
    }
}