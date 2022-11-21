<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EnregistrementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnregistrementRepository::class)]
#[ApiResource]
class Enregistrement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
