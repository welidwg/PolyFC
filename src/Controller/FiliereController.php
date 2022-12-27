<?php

namespace App\Controller;

use App\Entity\Filiere;
use App\Form\FiliereType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class FiliereController extends AbstractController
{
    /**
     * @Route("/filiere", name="filiere")
     */
    public function index(): Response
    {
        return $this->render('filiere/index.html.twig', [
            'controller_name' => 'FiliereController',
        ]);
    }

    /**
     * @Route("/filiere/add", name="filiere_add")
     */
    public function add_filiere(Request $req, AuthorizationCheckerInterface $authChecker): Response
    {
        if ($authChecker->isGranted("ROLE_ADMIN")) {
            $filiere = new Filiere();
            $form = $this->createForm(FiliereType::class, $filiere);
            $form->handleRequest($req);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($filiere);
                $em->flush();
                return $this->redirectToRoute("filiere");
            }
            return $this->render('filiere/ajouter_filiere.html.twig', [
                "form" => $form->createView()
            ]);
        }
        return $this->redirectToRoute("main");
    }
}
