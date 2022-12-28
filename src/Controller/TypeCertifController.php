<?php

namespace App\Controller;

use App\Entity\TypeCertif;
use App\Form\TypeCertifType;
use App\Repository\TypeCertifRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/type/certif")
 */
class TypeCertifController extends AbstractController
{
    /**
     * @Route("/", name="app_type_certif_index", methods={"GET"})
     */
    public function index(TypeCertifRepository $typeCertifRepository): Response
    {
        return $this->render('type_certif/index.html.twig', [
            'type_certifs' => $typeCertifRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_type_certif_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TypeCertifRepository $typeCertifRepository): Response
    {
        $typeCertif = new TypeCertif();
        $form = $this->createForm(TypeCertifType::class, $typeCertif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeCertifRepository->add($typeCertif, true);

            return $this->redirectToRoute('app_type_certif_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_certif/new.html.twig', [
            'type_certif' => $typeCertif,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_type_certif_show", methods={"GET"})
     */
    public function show(TypeCertif $typeCertif): Response
    {
        return $this->render('type_certif/show.html.twig', [
            'type_certif' => $typeCertif,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_type_certif_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TypeCertif $typeCertif, TypeCertifRepository $typeCertifRepository): Response
    {
        $form = $this->createForm(TypeCertifType::class, $typeCertif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeCertifRepository->add($typeCertif, true);

            return $this->redirectToRoute('app_type_certif_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_certif/edit.html.twig', [
            'type_certif' => $typeCertif,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_type_certif_delete", methods={"POST"})
     */
    public function delete(Request $request, TypeCertif $typeCertif, TypeCertifRepository $typeCertifRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeCertif->getId(), $request->request->get('_token'))) {
            $typeCertifRepository->remove($typeCertif, true);
        }

        return $this->redirectToRoute('app_type_certif_index', [], Response::HTTP_SEE_OTHER);
    }
}
