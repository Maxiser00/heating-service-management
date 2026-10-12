<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class CustomAuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): RedirectResponse
    {
        $user = $token->getUser();
        $roles = $user->getRoles();

        return match (true) {
            in_array('ROLE_ADMIN', $roles) => new RedirectResponse($this->router->generate('admin_dashboard')),
            in_array('ROLE_SECRETAIRE', $roles) => new RedirectResponse($this->router->generate('secretaire_dashboard')),
            in_array('ROLE_CHAUFFAGISTE', $roles) => new RedirectResponse($this->router->generate('chauffagiste_dashboard')),
            default => new RedirectResponse($this->router->generate('_login')),
        };
    }
}
