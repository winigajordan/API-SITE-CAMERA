<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FormuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormuleRepository::class)]
#[ApiResource]
class Formule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?float $prix1 = null;

    #[ORM\Column]
    private ?float $prix2 = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $details = null;

    #[ORM\OneToMany(mappedBy: 'formule', targetEntity: Abonnement::class)]
    private Collection $abonnements;

    public function __construct()
    {
        $this->abonnements = new ArrayCollection();
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

    public function getPrix1(): ?float
    {
        return $this->prix1;
    }

    public function setPrix1(float $prix1): self
    {
        $this->prix1 = $prix1;

        return $this;
    }

    public function getPrix2(): ?float
    {
        return $this->prix2;
    }

    public function setPrix2(float $prix2): self
    {
        $this->prix2 = $prix2;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): self
    {
        $this->details = $details;

        return $this;
    }

    /**
     * @return Collection<int, Abonnement>
     */
    public function getAbonnements(): Collection
    {
        return $this->abonnements;
    }

    public function addAbonnement(Abonnement $abonnement): self
    {
        if (!$this->abonnements->contains($abonnement)) {
            $this->abonnements->add($abonnement);
            $abonnement->setFormule($this);
        }

        return $this;
    }

    public function removeAbonnement(Abonnement $abonnement): self
    {
        if ($this->abonnements->removeElement($abonnement)) {
            // set the owning side to null (unless already changed)
            if ($abonnement->getFormule() === $this) {
                $abonnement->setFormule(null);
            }
        }

        return $this;
    }
}
