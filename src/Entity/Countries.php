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



    #[ORM\Column(length: 50)]
    private ?string $codeIso = null;

    /**
     * @var Collection<int, Staedte>
     */
    #[ORM\OneToMany(mappedBy: 'pays', targetEntity: Staedte::class)]
    private Collection $staedtes;

    public function __construct()
    {
        $this->manifestations = new ArrayCollection();
        $this->staedtes = new ArrayCollection();
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



    public function getCodeIso(): ?string
    {
        return $this->codeIso;
    }

    public function setCodeIso(string $codeIso): static
    {
        $this->codeIso = $codeIso;

        return $this;
    }

    /**
     * @return Collection<int, Staedte>
     */
    public function getStaedtes(): Collection
    {
        return $this->staedtes;
    }

    public function addStaedte(Staedte $staedte): static
    {
        if (!$this->staedtes->contains($staedte)) {
            $this->staedtes->add($staedte);
            $staedte->setPays($this);
        }

        return $this;
    }

    public function removeStaedte(Staedte $staedte): static
    {
        if ($this->staedtes->removeElement($staedte)) {
            // set the owning side to null (unless already changed)
            if ($staedte->getPays() === $this) {
                $staedte->setPays(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }
}
