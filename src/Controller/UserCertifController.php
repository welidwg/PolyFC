<?php

namespace App\Controller;

use App\Entity\UserCertif;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserCertifController extends AbstractController
{
    /**
     * @Route("/Demandes", name="demandes_certifs")
     */
    public function index(): Response
    {
        $users = $this->getDoctrine()->getRepository(UserCertif::class)->findAll();
        return $this->render('user_certif/demandes.html.twig', [
            'userCertifs' => $users,
        ]);
    }
}
