<?php

namespace Ace\CommonBundle\Security;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\AccessMap;

class RouteAcl
{
    private $accessMap;
    private $requestStack;

    public function __construct(AccessMap $accessMap, RequestStack $requestStack)
    {
        $this->accessMap = $accessMap;
        $this->requestStack = $requestStack;
    }

    public function getRoles($path)
    {
        $request = Request::create($path, 'GET', [], [], [], $this->requestStack->getMasterRequest()->server->all());
        list($roles, $channel) = $this->accessMap->getPatterns($request);

        return $roles;
    }
}