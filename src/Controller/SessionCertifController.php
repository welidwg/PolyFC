<?php

namespace App\Controller;

use App\Entity\SessionCertif;
use App\Form\SessionCertifType;
use App\Repository\SessionCertifRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/session/certif")
 */
class SessionCertifController extends AbstractController
{
    /**
     * @Route("/", name="app_session_certif_index", methods={"GET"})
     */
    public function index(SessionCertifRepository $sessionCertifRepository): Response
    {
        return $this->render('session_certif/index.html.twig', [
            'session_certifs' => $sessionCertifRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_session_certif_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SessionCertifRepository $sessionCertifRepository): Response
    {
        $sessionCertif = new SessionCertif();
        $form = $this->createForm(SessionCertifType::class, $sessionCertif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sessionCertifRepository->add($sessionCertif, true);

            return $this->redirectToRoute('app_session_certif_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('session_certif/new.html.twig', [
            'session_certif' => $sessionCertif,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_session_certif_show", methods={"GET"})
     */
    public function show(SessionCertif $sessionCertif): Response
    {
        return $this->render('session_certif/show.html.twig', [
            'session_certif' => $sessionCertif,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_session_certif_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, SessionCertif $sessionCertif, SessionCertifRepository $sessionCertifRepository): Response
    {
        $form = $this->createForm(SessionCertifType::class, $sessionCertif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sessionCertifRepository->add($sessionCertif, true);

            return $this->redirectToRoute('app_session_certif_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('session_certif/edit.html.twig', [
            'session_certif' => $sessionCertif,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_session_certif_delete", methods={"POST"})
     */
    public function delete(Request $request, SessionCertif $sessionCertif, SessionCertifRepository $sessionCertifRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sessionCertif->getId(), $request->request->get('_token'))) {
            $sessionCertifRepository->remove($sessionCertif, true);
        }

        return $this->redirectToRoute('app_session_certif_index', [], Response::HTTP_SEE_OTHER);
    }
}
