<?php

namespace App\Entity;

use App\Repository\UserCertifRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserCertifRepository::class)
 */
class UserCertif
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userCertifs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Certification::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $certif;

    /**
     * @ORM\Column(type="integer")
     */
    private $demande;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $resultat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCertif(): ?Certification
    {
        return $this->certif;
    }

    public function setCertif(?Certification $certif): self
    {
        $this->certif = $certif;

        return $this;
    }

    public function getDemande(): ?int
    {
        return $this->demande;
    }

    public function setDemande(int $demande): self
    {
        $this->demande = $demande;

        return $this;
    }

    public function getResultat(): ?int
    {
        return $this->resultat;
    }

    public function setResultat(?int $resultat): self
    {
        $this->resultat = $resultat;

        return $this;
    }
}
