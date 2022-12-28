<?php

namespace App\Controller;

use App\Entity\Certification;
use App\Form\CertificationType;
use App\Repository\CertificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/certif")
 */
class CertifController extends AbstractController
{
    /**
     * @Route("/", name="app_certif_index", methods={"GET"})
     */
    public function index(CertificationRepository $certificationRepository): Response
    {
        return $this->render('certif/index.html.twig', [
            'certifications' => $certificationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_certif_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CertificationRepository $certificationRepository): Response
    {
        $certification = new Certification();
        $form = $this->createForm(CertificationType::class, $certification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $certificationRepository->add($certification, true);

            return $this->redirectToRoute('app_certif_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('certif/new.html.twig', [
            'certification' => $certification,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_certif_show", methods={"GET"})
     */
    public function show(Certification $certification): Response
    {
        return $this->render('certif/show.html.twig', [
            'certification' => $certification,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_certif_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Certification $certification, CertificationRepository $certificationRepository): Response
    {
        $form = $this->createForm(CertificationType::class, $certification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $certificationRepository->add($certification, true);

            return $this->redirectToRoute('app_certif_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('certif/edit.html.twig', [
            'certification' => $certification,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_certif_delete", methods={"POST"})
     */
    public function delete(Request $request, Certification $certification, CertificationRepository $certificationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$certification->getId(), $request->request->get('_token'))) {
            $certificationRepository->remove($certification, true);
        }

        return $this->redirectToRoute('app_certif_index', [], Response::HTTP_SEE_OTHER);
    }
}
