<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\NiveauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NiveauRepository::class)]
#[ApiResource]
class Niveau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\ManyToOne(inversedBy: 'niveaux')]
    private ?Site $site = null;

    #[ORM\OneToMany(mappedBy: 'niveau', targetEntity: Camera::class)]
    private Collection $cameras;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->cameras = new ArrayCollection();
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

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }

    /**
     * @return Collection<int, Camera>
     */
    public function getCameras(): Collection
    {
        return $this->cameras;
    }

    public function addCamera(Camera $camera): self
    {
        if (!$this->cameras->contains($camera)) {
            $this->cameras->add($camera);
            $camera->setNiveau($this);
        }

        return $this;
    }

    public function removeCamera(Camera $camera): self
    {
        if ($this->cameras->removeElement($camera)) {
            // set the owning side to null (unless already changed)
            if ($camera->getNiveau() === $this) {
                $camera->setNiveau(null);
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
}
