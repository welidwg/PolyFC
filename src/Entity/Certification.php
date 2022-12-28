<?php

namespace App\Entity;

use App\Repository\CertificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity=Formation::class, mappedBy="idCertif")
     */
    private $idCertif;

    /**
     * @ORM\OneToMany(targetEntity=Formation::class, mappedBy="certification")
     */
    private $formations;

    public function __construct()
    {
        $this->idCertif = new ArrayCollection();
        $this->formations = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Formation>
     */
    public function getIdCertif(): Collection
    {
        return $this->idCertif;
    }


 
    /**
     * @return Collection<int, Formation>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations[] = $formation;
            $formation->setCertification($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formations->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getCertification() === $this) {
                $formation->setCertification(null);
            }
        }

        return $this;
    }
}
