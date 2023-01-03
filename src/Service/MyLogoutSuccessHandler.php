<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

class MyLogoutSuccessHandler extends AbstractController implements LogoutSuccessHandlerInterface
{
    private $router;
    /**
     * AfterLoginRedirection constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }
    /**
     * {@inheritdoc}
     */
    public function onLogoutSuccess(Request $request)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($this->getUser()->getId());
        $user->setActif(0);
        $em = $this->getDoctrine()->getManager();
        $em->merge($user);
        $em->flush();
        // you can do anything here
        return new RedirectResponse($this->router->generate("login"));
    }
}
