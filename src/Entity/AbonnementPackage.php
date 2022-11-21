<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AbonnementPackageRepository;
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
}
