<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
#[ApiResource]
class Entreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rccm = null;

    #[ORM\Column(length: 255)]
    private ?string $ninea = null;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: AbonnementPackage::class)]
    private Collection $abonnementPackages;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\ManyToOne(inversedBy: 'entreprises')]
    private ?Referent $referent = null;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: Inscription::class)]
    private Collection $inscriptions;



    public function __construct()
    {
        $this->abonnementPackages = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
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

    public function getRccm(): ?string
    {
        return $this->rccm;
    }

    public function setRccm(?string $rccm): self
    {
        $this->rccm = $rccm;

        return $this;
    }

    public function getNinea(): ?string
    {
        return $this->ninea;
    }

    public function setNinea(string $ninea): self
    {
        $this->ninea = $ninea;

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
            $abonnementPackage->setEntreprise($this);
        }

        return $this;
    }

    public function removeAbonnementPackage(AbonnementPackage $abonnementPackage): self
    {
        if ($this->abonnementPackages->removeElement($abonnementPackage)) {
            // set the owning side to null (unless already changed)
            if ($abonnementPackage->getEntreprise() === $this) {
                $abonnementPackage->setEntreprise(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getReferent(): ?Referent
    {
        return $this->referent;
    }

    public function setReferent(?Referent $referent): self
    {
        $this->referent = $referent;

        return $this;
    }

    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions->add($inscription);
            $inscription->setEntreprise($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getEntreprise() === $this) {
                $inscription->setEntreprise(null);
            }
        }

        return $this;
    }

}
