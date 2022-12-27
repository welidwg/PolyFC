<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
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
    private $libelleFormation;

    /**
     * @ORM\ManyToOne(targetEntity=Certification::class, inversedBy="idCertif")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idCertif;

    /**
     * @ORM\ManyToMany(targetEntity=Enseignant::class, inversedBy="idEnseignant")
     */
    private $idEnseignant;

    public function __construct()
    {
        $this->idEnseignant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleFormation(): ?string
    {
        return $this->libelleFormation;
    }

    public function setLibelleFormation(string $libelleFormation): self
    {
        $this->libelleFormation = $libelleFormation;

        return $this;
    }

    public function getIdCertif(): ?Certification
    {
        return $this->idCertif;
    }

    public function setIdCertif(?Certification $idCertif): self
    {
        $this->idCertif = $idCertif;

        return $this;
    }

    /**
     * @return Collection<int, Enseignant>
     */
    public function getIdEnseignant(): Collection
    {
        return $this->idEnseignant;
    }

    public function addIdEnseignant(Enseignant $idEnseignant): self
    {
        if (!$this->idEnseignant->contains($idEnseignant)) {
            $this->idEnseignant[] = $idEnseignant;
        }

        return $this;
    }

    public function removeIdEnseignant(Enseignant $idEnseignant): self
    {
        $this->idEnseignant->removeElement($idEnseignant);

        return $this;
    }
}
