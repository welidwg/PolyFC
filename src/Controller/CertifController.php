<?php

namespace App\Controller;

use App\Entity\Certification;
use App\Entity\UserCertif;
use App\Form\CertificationType;
use App\Repository\CertificationRepository;
use App\Repository\UserCertifRepository;
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
     * @Route("/MesCertifs", name="app_mes_certifs", methods={"GET"})
     */
    public function userCertifIndex(): Response
    {
        return $this->render('etudiant/certifs.html.twig', []);
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
        if ($this->isCsrfTokenValid('delete' . $certification->getId(), $request->request->get('_token'))) {
            $certificationRepository->remove($certification, true);
        }

        return $this->redirectToRoute('app_certif_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/userCertif/{id}", name="app_certif_usercertif", methods={"POST","GET"})
     */
    public function userCertif(Request $request, UserCertifRepository $userCertifRepository, CertificationRepository $certificationRepository, $id): Response
    {
        $userCertif = new UserCertif();
        $certif = $certificationRepository->find($id);

        $userCertif->setCertif($certif);
        $userCertif->setUser($this->getUser());
        $userCertif->setDemande(0);
        $em = $this->getDoctrine()->getManager();
        $em->persist($userCertif);
        $em->flush();

        return $this->redirectToRoute('app_certif_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/userCertif/cancel/{id}", name="app_certif_usercertif_cancel", methods={"POST","GET"})
     */
    public function userCertifCancel(Request $request, UserCertifRepository $userCertifRepository, $id): Response
    {

        $em = $this->getDoctrine()->getManager();
        $userCert = $userCertifRepository->find($id);
        if ($userCert) {
            $em->remove($userCert);
            $em->flush();
        }


        return $this->redirectToRoute('app_certif_index', [], Response::HTTP_SEE_OTHER);
    }
}
