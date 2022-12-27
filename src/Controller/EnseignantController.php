<?php

namespace App\Controller;

use App\Entity\Enseignant;
use App\Form\EnseignantType;
use App\Repository\EnseignantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/enseignant")
     */
class EnseignantController extends AbstractController
{
    /**
     * @Route("/",name="app_enseignant_index")
     * Methods({"GET"})
     */
    public function index(EnseignantRepository $enseignantRepository): Response
    {
        return $this->render('enseignant/index.html.twig', [
            'enseignants' => $enseignantRepository->findAll(),
        ]);
    }
    
    /**
     * @Route("/new",name="app_enseignant_new")
     * Methods({"GET","POST"})
     */
    public function new(Request $request, EnseignantRepository $enseignantRepository): Response
    {
        $enseignant = new Enseignant();
        $form = $this->createForm(EnseignantType::class, $enseignant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $enseignantRepository->add($enseignant, true);

            return $this->redirectToRoute('app_enseignant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('enseignant/new.html.twig', [
            'enseignant' => $enseignant,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/{id}",name="app_enseignant_show")
     * Methods({"GET"})
     */
    public function show(Enseignant $enseignant): Response
    {
        return $this->render('enseignant/show.html.twig', [
            'enseignant' => $enseignant,
        ]);
    }
    /**
     * @Route("/{id}/edit",name="app_enseignant_edit")
     * Methods({"GET","POST"})
     */
    public function edit(Request $request, Enseignant $enseignant, EnseignantRepository $enseignantRepository): Response
    {
        $form = $this->createForm(EnseignantType::class, $enseignant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $enseignantRepository->add($enseignant, true);

            return $this->redirectToRoute('app_enseignant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('enseignant/edit.html.twig', [
            'enseignant' => $enseignant,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/{id}",name="app_enseignant_delete")
     * Methods({"POST"})
     */
    public function delete(Request $request, Enseignant $enseignant, EnseignantRepository $enseignantRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$enseignant->getId(), $request->request->get('_token'))) {
            $enseignantRepository->remove($enseignant, true);
        }

        return $this->redirectToRoute('app_enseignant_index', [], Response::HTTP_SEE_OTHER);
    }
}
