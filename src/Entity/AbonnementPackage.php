<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AbonnementPackageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbonnementPackageRepository::class)]
#[ApiResource]
class AbonnementPackage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    #[ORM\ManyToOne(inversedBy: 'abonnementPackages')]
    private ?Package $package = null;

    #[ORM\ManyToOne(inversedBy: 'abonnementPackages')]
    private ?Entreprise $entreprise = null;

    #[ORM\OneToMany(mappedBy: 'abonnement', targetEntity: ReglementPackage::class)]
    private Collection $reglementPackages;

    public function __construct()
    {
        $this->reglementPackages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getPackage(): ?Package
    {
        return $this->package;
    }

    public function setPackage(?Package $package): self
    {
        $this->package = $package;

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * @return Collection<int, ReglementPackage>
     */
    public function getReglementPackages(): Collection
    {
        return $this->reglementPackages;
    }

    public function addReglementPackage(ReglementPackage $reglementPackage): self
    {
        if (!$this->reglementPackages->contains($reglementPackage)) {
            $this->reglementPackages->add($reglementPackage);
            $reglementPackage->setAbonnement($this);
        }

        return $this;
    }

    public function removeReglementPackage(ReglementPackage $reglementPackage): self
    {
        if ($this->reglementPackages->removeElement($reglementPackage)) {
            // set the owning side to null (unless already changed)
            if ($reglementPackage->getAbonnement() === $this) {
                $reglementPackage->setAbonnement(null);
            }
        }

        return $this;
    }
}
