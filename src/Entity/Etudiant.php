<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtudiantRepository::class)
 */
class Etudiant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="idEtudiant")
     */
    private $iduser;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $matricule;

    /**
     * @ORM\Column(type="date")
     */
    private $dateN;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieuNaissance;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $cin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $passeport;

    /**
     * @ORM\Column(type="integer", length=8)
     */
    private $telParent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $emailParent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $etatCivil;

    /**
     * @ORM\ManyToOne(targetEntity=Filiere::class)
     */
    private $filiere;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getDateN(): ?\DateTimeInterface
    {
        return $this->dateN;
    }

    public function setDateN(\DateTimeInterface $dateN): self
    {
        $this->dateN = $dateN;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieuNaissance;
    }

    public function setLieuNaissance(string $lieuNaissance): self
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(?string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getPasseport(): ?string
    {
        return $this->passeport;
    }

    public function setPasseport(?string $passeport): self
    {
        $this->passeport = $passeport;

        return $this;
    }

    public function getTelParent(): ?int
    {
        return $this->telParent;
    }

    public function setTelParent(int $telParent): self
    {
        $this->telParent = $telParent;

        return $this;
    }

    public function getEmailParent(): ?string
    {
        return $this->emailParent;
    }

    public function setEmailParent(?string $emailParent): self
    {
        $this->emailParent = $emailParent;

        return $this;
    }

    public function getEtatCivil(): ?string
    {
        return $this->etatCivil;
    }

    public function setEtatCivil(?string $etatCivil): self
    {
        $this->etatCivil = $etatCivil;

        return $this;
    }

    public function getFiliere(): ?Filiere
    {
        return $this->filiere;
    }

    public function setFiliere(?Filiere $filiere): self
    {
        $this->filiere = $filiere;

        return $this;
    }
}
