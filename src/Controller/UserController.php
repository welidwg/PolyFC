<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\User;
use App\Form\EtudiantType;
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

            $user->setRoles(array("ROLE_STUDENT"));
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
    public function main(AuthorizationCheckerInterface $authChecker): Response
    {
        if ($authChecker->isGranted("ROLE_STUDENT")) {
            $std = $this->getDoctrine()->getRepository(Etudiant::class)->findOneBy(["iduser" => $this->getUser()->getId()]);
            if (!$std) {
                return $this->redirectToRoute("student");
            }
        }

        return $this->render("main/index.html.twig");
    }
    /**
     * @Route("/student", name="student")
     */
    public function student(Request $req, AuthorizationCheckerInterface $authChecker): Response
    {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $etudiant->setIduser($this->getUser());
            $em->persist($etudiant);
            $em->flush();
            return $this->redirectToRoute('main', [
                "messageSign" => "success"
            ]);
        }
        return $this->render("main/add_student.html.twig", ["error" => null, "form" => $form->createView()]);
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile(Request $req, AuthorizationCheckerInterface $authChecker, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        if ($authChecker->isGranted("IS_AUTHENTICATED_FULLY")) {
            $user = $this->getDoctrine()->getRepository(User::class)->find($this->getUser()->getId());
            $std = $this->getDoctrine()->getRepository(Etudiant::class)->findOneBy(["iduser" => $this->getUser()->getId()]);
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($req);
            $formStd = $this->createForm(EtudiantType::class, $std);
            $formStd->handleRequest($req);
            if ($form->isSubmitted() && $form->isValid()) {
                //do not enter here
                $password = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
            }

            if ($formStd->isSubmitted() && $formStd->isValid()) {
                //do not enter here
                $em = $this->getDoctrine()->getManager();
                $em->persist($std);
                $em->flush();
            }
            return $this->render("main/profile.html.twig", ["form" => $form->createView(), "formStd" => $formStd->createView()]);
        } else {
            return $this->redirectToRoute("main");
        }
    }
}
