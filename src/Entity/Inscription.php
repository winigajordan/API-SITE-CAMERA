<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\InscriptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
#[ApiResource]
class Inscription
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etatInscription = null;


    #[ORM\Column(length: 255)]
    private ?string $nom = null;


    #[ORM\Column(length: 255)]
    private ?string $prenom = null;


    #[ORM\Column(length: 255)]
    private ?string $mail = null;


    #[ORM\Column(length: 255)]
    private ?string $login = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $password = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telephone = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $region = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pays = null;


    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $adresse = null;


    #[ORM\OneToOne(mappedBy: 'inscription', cascade: ['persist', 'remove'])]
    private ?AbonnementInscription $abonnementInscription = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    private ?Entreprise $entreprise = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isEtatInscription(): ?bool
    {
        return $this->etatInscription;
    }

    public function setEtatInscription(?bool $etatInscription): self
    {
        $this->etatInscription = $etatInscription;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getAbonnementInscription(): ?AbonnementInscription
    {
        return $this->abonnementInscription;
    }

    public function setAbonnementInscription(?AbonnementInscription $abonnementInscription): self
    {
        // unset the owning side of the relation if necessary
        if ($abonnementInscription === null && $this->abonnementInscription !== null) {
            $this->abonnementInscription->setInscription(null);
        }

        // set the owning side of the relation if necessary
        if ($abonnementInscription !== null && $abonnementInscription->getInscription() !== $this) {
            $abonnementInscription->setInscription($this);
        }

        $this->abonnementInscription = $abonnementInscription;

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
