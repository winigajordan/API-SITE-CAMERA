<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AbonnementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbonnementRepository::class)]
#[ApiResource]
class Abonnement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $etatAbonnement = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column]
    private ?float $frais = null;

    #[ORM\Column]
    private ?bool $etatFrais = null;

    #[ORM\Column]
    private ?int $nbrNiveau = null;

    #[ORM\Column]
    private ?int $nbrCamera = null;

    #[ORM\ManyToOne(inversedBy: 'abonnements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'abonnements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Formule $formule = null;

    #[ORM\OneToMany(mappedBy: 'abonnement', targetEntity: ReglementAbonnement::class)]
    private Collection $reglementAbonnements;

    #[ORM\OneToOne(mappedBy: 'abonnement', cascade: ['persist', 'remove'])]
    private ?Site $site = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->reglementAbonnements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtatAbonnement(): ?string
    {
        return $this->etatAbonnement;
    }

    public function setEtatAbonnement(string $etatAbonnement): self
    {
        $this->etatAbonnement = $etatAbonnement;

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

    public function getFrais(): ?float
    {
        return $this->frais;
    }

    public function setFrais(float $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

    public function isEtatFrais(): ?bool
    {
        return $this->etatFrais;
    }

    public function setEtatFrais(bool $etatFrais): self
    {
        $this->etatFrais = $etatFrais;

        return $this;
    }

    public function getNbrNiveau(): ?int
    {
        return $this->nbrNiveau;
    }

    public function setNbrNiveau(int $nbrNiveau): self
    {
        $this->nbrNiveau = $nbrNiveau;

        return $this;
    }

    public function getNbrCamera(): ?int
    {
        return $this->nbrCamera;
    }

    public function setNbrCamera(int $nbrCamera): self
    {
        $this->nbrCamera = $nbrCamera;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFormule(): ?Formule
    {
        return $this->formule;
    }

    public function setFormule(?Formule $formule): self
    {
        $this->formule = $formule;

        return $this;
    }

    /**
     * @return Collection<int, ReglementAbonnement>
     */
    public function getReglementAbonnements(): Collection
    {
        return $this->reglementAbonnements;
    }

    public function addReglementAbonnement(ReglementAbonnement $reglementAbonnement): self
    {
        if (!$this->reglementAbonnements->contains($reglementAbonnement)) {
            $this->reglementAbonnements->add($reglementAbonnement);
            $reglementAbonnement->setAbonnement($this);
        }

        return $this;
    }

    public function removeReglementAbonnement(ReglementAbonnement $reglementAbonnement): self
    {
        if ($this->reglementAbonnements->removeElement($reglementAbonnement)) {
            // set the owning side to null (unless already changed)
            if ($reglementAbonnement->getAbonnement() === $this) {
                $reglementAbonnement->setAbonnement(null);
            }
        }

        return $this;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(Site $site): self
    {
        // set the owning side of the relation if necessary
        if ($site->getAbonnement() !== $this) {
            $site->setAbonnement($this);
        }

        $this->site = $site;

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
}
