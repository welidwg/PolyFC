<?php

namespace App\Controller;

use App\Entity\Enseignant;
use App\Entity\Etudiant;
use App\Entity\User;
use App\Form\EnseignantType;
use App\Form\EtudiantType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
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
        // $user = $this->getDoctrine()->getRepository(User::class)->find($this->getUser()->getId());
        // $user->setActif(0);
        // $em = $this->getDoctrine()->getManager();
        // $em->merge($user);
        // $em->flush();
        // return $this->redirectToRoute("login");
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
            $teacher = $this->getDoctrine()->getRepository(Enseignant::class)->findOneBy(["iduser" => $this->getUser()->getId()]);
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($req);
            $formStd = $this->createForm(EtudiantType::class, $std);
            $formStd->handleRequest($req);
            $formTeacher = $this->createForm(EnseignantType::class, $teacher);
            $formTeacher->handleRequest($req);
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
            if ($formTeacher->isSubmitted() && $formTeacher->isValid()) {
                //do not enter here
                $em = $this->getDoctrine()->getManager();
                $em->persist($teacher);
                $em->flush();
            }
            return $this->render("main/profile.html.twig", ["form" => $form->createView(), "formStd" => $formStd->createView(), "formTeacher" => $formTeacher->createView()]);
        } else {
            return $this->redirectToRoute("main");
        }
    }
    /**
     * @Route("/admin/userCreate", name="admin_create_user")
     */
    public function userCreate(Request $req, AuthorizationCheckerInterface $authChecker, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $seesion = new Session();
            $seesion->getFlashBag()->add("message", ["type" => "success", "content" => "Candidat bien ajouté"]);
            $user->setRoles(array("ROLE_TEACHER"));
            $user->setActif(0);
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('admin_create_user', ["message" => ["type" => "success", "content" => "Utilisateur bien crée"]]);
        }
        return $this->render("admin/create_user.html.twig", ["error" => null, "form" => $form->createView()]);
    }

    /**
     * @Route("/admin/createTeacher", name="admin_create_teacher")
     */
    public function teacherCreate(Request $req, AuthorizationCheckerInterface $authChecker): Response
    {
        $user = new Enseignant();
        $form = $this->createForm(EnseignantType::class, $user);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $seesion = new Session();
            $seesion->getFlashBag()->add("message", ["type" => "success", "content" => "Enseignant bien ajouté"]);
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('admin_create_teacher');
        }
        return $this->render("admin/create_teacher.html.twig", ["error" => null, "form" => $form->createView()]);
    }

    /**
     * @Route("/user/details/{id}", name="user_details")
     */
    public function userDetails(Request $req, AuthorizationCheckerInterface $authChecker, $id): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $details = [];
        $role = "";

        if ($user) {
            $roles = $user->getRoles();



            if (in_array('ROLE_STUDENT', $roles)) {
                $role = "ROLE_STUDENT";
                $details = $this->getDoctrine()->getRepository(Etudiant::class)->findOneBy(["iduser" => $id]);
            } else if (in_array('ROLE_TEACHER', $roles)) {
                $role = "ROLE_TEACHER";

                $details = $this->getDoctrine()->getRepository(Enseignant::class)->findOneBy(["iduser" => $id]);
            }
        }
        return $this->render("admin/userDetails.html.twig", ["error" => null, "user" => $user, "details" => $details, "role" => $role]);
    }
}
