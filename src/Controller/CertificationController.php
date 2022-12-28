<?php

namespace App\Controller;

use App\Entity\Certification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CertificationController extends AbstractController
{
    /**
     * @Route("/certification", name="certification")
     */
    public function index(): Response
    {
        $certifs = $this->getDoctrine()->getRepository(Certification::class)->findAll();
        return $this->render('admin/certification/certification.html.twig', [
            'certifs' => $certifs
        ]);
    }
}
