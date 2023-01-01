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
    /**
     * @Route("/Demandes/Accepter/{id}", name="demandes_certifs_accepter")
     */
    public function Accept($id): Response
    {
        try {
            $crt = $this->getDoctrine()->getRepository(UserCertif::class)->find($id);
            $crt->setDemande(1);
            $em = $this->getDoctrine()->getManager();
            $em->merge($crt);
            $em->flush();
            return $this->redirectToRoute("demandes_certifs", ["error" => "non"]);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->redirectToRoute("demandes_certifs", ["error" => $th->getMessage()]);
        }
    }
    /**
     * @Route("/Demandes/Refuser/{id}", name="demandes_certifs_refuser")
     */
    public function Refuser($id): Response
    {
        try {
            $crt = $this->getDoctrine()->getRepository(UserCertif::class)->find($id);
            $crt->setDemande(2);
            $em = $this->getDoctrine()->getManager();
            $em->merge($crt);
            $em->flush();
            return $this->redirectToRoute("demandes_certifs");
        } catch (\Throwable $th) {
            //throw $th;
            return $this->redirectToRoute("demandes_certifs");
        }
    }
}
