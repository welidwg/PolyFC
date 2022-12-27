<?php

namespace App\Entity;

use App\Repository\CertificationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CertificationRepository::class)
 */
class Certification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity=TypeCertif::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeCertif;

    /**
     * @ORM\ManyToOne(targetEntity=SessionCertif::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $sessionCertif;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getTypeCertif(): ?TypeCertif
    {
        return $this->typeCertif;
    }

    public function setTypeCertif(?TypeCertif $typeCertif): self
    {
        $this->typeCertif = $typeCertif;

        return $this;
    }

    public function getSessionCertif(): ?SessionCertif
    {
        return $this->sessionCertif;
    }

    public function setSessionCertif(?SessionCertif $sessionCertif): self
    {
        $this->sessionCertif = $sessionCertif;

        return $this;
    }
}
