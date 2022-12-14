<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PackageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PackageRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
)]
class Package
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['read', 'write'])]
    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[Groups(['read', 'write'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $details = null;

    #[Groups(['read', 'write'])]
    #[ORM\Column]
    private ?float $prix = null;

    #[Groups(['read'])]
    #[ORM\OneToMany(mappedBy: 'package', targetEntity: AbonnementPackage::class)]
    private Collection $abonnementPackages;

    #[Groups(['read', 'write'])]
    #[ORM\Column]
    private ?bool $etat = null;

    public function __construct()
    {
        $this->abonnementPackages = new ArrayCollection();
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

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, AbonnementPackage>
     */
    public function getAbonnementPackages(): Collection
    {
        return $this->abonnementPackages;
    }

    public function addAbonnementPackage(AbonnementPackage $abonnementPackage): self
    {
        if (!$this->abonnementPackages->contains($abonnementPackage)) {
            $this->abonnementPackages->add($abonnementPackage);
            $abonnementPackage->setPackage($this);
        }

        return $this;
    }

    public function removeAbonnementPackage(AbonnementPackage $abonnementPackage): self
    {
        if ($this->abonnementPackages->removeElement($abonnementPackage)) {
            // set the owning side to null (unless already changed)
            if ($abonnementPackage->getPackage() === $this) {
                $abonnementPackage->setPackage(null);
            }
        }

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
