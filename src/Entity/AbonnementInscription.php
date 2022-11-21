<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AbonnementInscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbonnementInscriptionRepository::class)]
#[ApiResource]
class AbonnementInscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column]
    private ?float $frais = null;

    #[ORM\Column]
    private ?int $nbrNiveau = null;

    #[ORM\Column]
    private ?int $nbrCamera = null;

    #[ORM\OneToOne(inversedBy: 'abonnementInscription', cascade: ['persist', 'remove'])]
    private ?Inscription $inscription = null;

    #[ORM\ManyToOne]
    private ?Formule $formule = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getInscription(): ?Inscription
    {
        return $this->inscription;
    }

    public function setInscription(?Inscription $inscription): self
    {
        $this->inscription = $inscription;

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
}
