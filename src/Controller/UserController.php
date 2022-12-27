<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
            $role=$this->getDoctrine()->getManager()->find();

            $user->setRole($role);
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
    public function login(): Response
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
