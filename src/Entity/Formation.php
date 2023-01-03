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
     * @ORM\OneToMany(targetEntity=FormationEtudiant::class, mappedBy="formation")
     */
    private $formation;

    /**
     * @ORM\ManyToOne(targetEntity=Certification::class, inversedBy="formations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $certification;

    /**
     * @ORM\ManyToOne(targetEntity=Enseignant::class, inversedBy="formations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $enseignant;

    public function __construct()
    {
        $this->formation = new ArrayCollection();
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

    /**
     * @return Collection<int, FormationEtudiant>
     */
    public function getFormation(): Collection
    {
        return $this->formation;
    }

    public function addFormation(FormationEtudiant $formation): self
    {
        if (!$this->formation->contains($formation)) {
            $this->formation[] = $formation;
            $formation->setFormation($this);
        }

        return $this;
    }

    public function removeFormation(FormationEtudiant $formation): self
    {
        if ($this->formation->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getFormation() === $this) {
                $formation->setFormation(null);
            }
        }

        return $this;
    }

    public function getCertification(): ?Certification
    {
        return $this->certification;
    }

    public function setCertification(?Certification $certification): self
    {
        $this->certification = $certification;

        return $this;
    }

    public function getEnseignant(): ?Enseignant
    {
        return $this->enseignant;
    }

    public function setEnseignant(?Enseignant $enseignant): self
    {
        $this->enseignant = $enseignant;

        return $this;
    }
}
