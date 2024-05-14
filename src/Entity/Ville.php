<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups as AttributeGroups;

#[ORM\Entity(repositoryClass: VilleRepository::class)]
class Ville
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[AttributeGroups(['ville:read'])]
    private ?string $nom = null;


    #[ORM\Column(length: 255)]
    #[AttributeGroups(['ville:read'])]
    private ?string $code = null;

    #[ORM\ManyToOne(inversedBy: 'villes')]
    private ?Countries $countries = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }



    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getCountries(): ?Countries
    {
        return $this->countries;
    }

    public function setCountries(?Countries $countries): static
    {
        $this->countries = $countries;

        return $this;
    }
}
