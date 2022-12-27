<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $req, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $em = $this->getDoctrine()->getManager();

            $user->setRoles(array("ROLE_USER"));
            $user->setActif(0);
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('login', [
                'user' => $user,
                "messageSign" => "success"
            ]);
        }

        return $this->render("main/register.html.twig", array('form' => $form->createView()));
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils, AuthorizationCheckerInterface $authChecker): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        // get the login error if there is one
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render("main/login.html.twig", [
            'last_matricule' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(): Response
    {
        return $this->render("main/login.html.twig");
    }
    /**
     * @Route("/", name="main")
     */
    public function main(): Response
    {
        return $this->render("main/index.html.twig");
    }
    /**
     * @Route("/user", name="app_user")
     */
    public function index(): Response
    {
        return $this->render("base.html.twig");
    }
}
