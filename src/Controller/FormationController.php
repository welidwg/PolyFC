<?php

namespace App\Controller;

use App\Entity\Enseignant;
use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/formation")
 */

class FormationController extends AbstractController
{
    /**
     * @Route("/",name="app_formation_index")
     * Methods({"GET"})
     */
    public function index(FormationRepository $formationRepository): Response
    {
        return $this->render('formation/index.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }
    /**
     * @Route("/enseignant",name="app_formation_enseignant")
     * Methods({"GET"})
     */
    public function enseignant(FormationRepository $formationRepository): Response
    {
        $user = $this->getUser()->getId();
        $ens = $this->getDoctrine()->getRepository(Enseignant::class)->findOneBy(["iduser" => $user]);
        return $this->render('enseignant/formation.html.twig', [
            'formations' => $formationRepository->findBy(["enseignant" => $ens->getId()]), "test" => $ens->getId()
        ]);
    }
    /**
     * @Route("/new",name="app_formation_new")
     * Methods({"GET","POST"})
     */
    public function new(Request $request, FormationRepository $formationRepository): Response
    {
        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formationRepository->add($formation, true);

            return $this->redirectToRoute('app_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('formation/new.html.twig', [
            'formation' => $formation,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/{id}",name="app_formation_show")
     * Methods({"GET"})
     */
    public function show(Formation $formation): Response
    {
        return $this->render('formation/show.html.twig', [
            'formation' => $formation,
        ]);
    }
    /**
     * @Route("/{id}/edit",name="app_formation_edit")
     * Methods({"GET","POST"})
     */
    public function edit(Request $request, Formation $formation, FormationRepository $formationRepository): Response
    {
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formationRepository->add($formation, true);

            return $this->redirectToRoute('app_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('formation/edit.html.twig', [
            'formation' => $formation,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/{id}",name="app_formation_delete")
     * Methods({"POST"})
     */
    public function delete(Request $request, Formation $formation, FormationRepository $formationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $formation->getId(), $request->request->get('_token'))) {
            $formationRepository->remove($formation, true);
        }

        return $this->redirectToRoute('app_formation_index', [], Response::HTTP_SEE_OTHER);
    }
}
