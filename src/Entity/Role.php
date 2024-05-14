<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, PorteursDeProjet>
     */
    #[ORM\OneToMany(mappedBy: 'role', targetEntity: Kontakt::class)]
    private Collection $porteursDeProjets;

    public function __construct()
    {
        $this->porteursDeProjets = new ArrayCollection();
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
     * @return Collection<int, PorteursDeProjet>
     */
    public function getPorteursDeProjets(): Collection
    {
        return $this->porteursDeProjets;
    }

    public function addPorteursDeProjet(Kontakt $porteursDeProjet): static
    {
        if (!$this->porteursDeProjets->contains($porteursDeProjet)) {
            $this->porteursDeProjets->add($porteursDeProjet);
            $porteursDeProjet->setRole($this);
        }

        return $this;
    }

    public function removePorteursDeProjet(Kontakt $porteursDeProjet): static
    {
        if ($this->porteursDeProjets->removeElement($porteursDeProjet)) {
            // set the owning side to null (unless already changed)
            if ($porteursDeProjet->getRole() === $this) {
                $porteursDeProjet->setRole(null);
            }
        }

        return $this;
    }
}
