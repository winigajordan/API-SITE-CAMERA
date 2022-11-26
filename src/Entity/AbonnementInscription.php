<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AbonnementInscriptionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AbonnementInscriptionRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
)]
class AbonnementInscription
{
    #[Groups(['read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['read', 'write'])]
    #[ORM\Column]
    private ?float $prix = null;

    #[Groups(['read', 'write'])]
    #[ORM\Column]
    private ?float $frais = null;

    #[Groups(['read', 'write'])]
    #[ORM\Column]
    private ?int $nbrNiveau = null;

    #[Groups(['read', 'write'])]
    #[ORM\Column]
    private ?int $nbrCamera = null;

    #[Groups(['read'])]
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
