<?php

namespace App\Entity;

use App\Repository\EnseignantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnseignantRepository::class)
 */
class Enseignant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="iduser")
     * @ORM\JoinColumn(nullable=false)
     */
    private $iduser;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $matricule;

    /**
     * @ORM\Column(type="date")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Addresse;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $cin;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $passeport;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $specialite;

    /**
     * @ORM\ManyToMany(targetEntity=Formation::class, mappedBy="idEnseignant")
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

    public function getIduser(): ?user
    {
        return $this->iduser;
    }

    public function setIduser(?user $iduser): self
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

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

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

    public function getAddresse(): ?string
    {
        return $this->Addresse;
    }

    public function setAddresse(string $Addresse): self
    {
        $this->Addresse = $Addresse;

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

    public function getPasseport(): ?int
    {
        return $this->passeport;
    }

    public function setPasseport(?int $passeport): self
    {
        $this->passeport = $passeport;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getIdEnseignant(): Collection
    {
        return $this->idEnseignant;
    }

    public function addIdEnseignant(Formation $idEnseignant): self
    {
        if (!$this->idEnseignant->contains($idEnseignant)) {
            $this->idEnseignant[] = $idEnseignant;
            $idEnseignant->addIdEnseignant($this);
        }

        return $this;
    }

    public function removeIdEnseignant(Formation $idEnseignant): self
    {
        if ($this->idEnseignant->removeElement($idEnseignant)) {
            $idEnseignant->removeIdEnseignant($this);
        }

        return $this;
    }
}
