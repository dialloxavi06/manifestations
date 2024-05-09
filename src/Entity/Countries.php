<?php

namespace App\Entity;

use App\Repository\CountriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountriesRepository::class)]
class Countries
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Manifestation>
     */
    #[ORM\ManyToMany(targetEntity: Manifestation::class, mappedBy: 'countries')]
    private Collection $manifestations;

    /**
     * @var Collection<int, Ville>
     */
    #[ORM\OneToMany(mappedBy: 'countries', targetEntity: Ville::class)]
    private Collection $villes;

    #[ORM\Column(length: 50)]
    private ?string $codeIso = null;

    public function __construct()
    {
        $this->manifestations = new ArrayCollection();
        $this->villes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Manifestation>
     */
    public function getManifestations(): Collection
    {
        return $this->manifestations;
    }

    public function addManifestation(Manifestation $manifestation): static
    {
        if (!$this->manifestations->contains($manifestation)) {
            $this->manifestations->add($manifestation);
            $manifestation->addCountry($this);
        }

        return $this;
    }

    public function removeManifestation(Manifestation $manifestation): static
    {
        if ($this->manifestations->removeElement($manifestation)) {
            $manifestation->removeCountry($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Ville>
     */
    public function getVilles(): Collection
    {
        return $this->villes;
    }

    public function addVille(Ville $ville): static
    {
        if (!$this->villes->contains($ville)) {
            $this->villes->add($ville);
            $ville->setCountries($this);
        }

        return $this;
    }

    public function removeVille(Ville $ville): static
    {
        if ($this->villes->removeElement($ville)) {
            // set the owning side to null (unless already changed)
            if ($ville->getCountries() === $this) {
                $ville->setCountries(null);
            }
        }

        return $this;
    }

    public function getCodeIso(): ?string
    {
        return $this->codeIso;
    }

    public function setCodeIso(string $codeIso): static
    {
        $this->codeIso = $codeIso;

        return $this;
    }
}
