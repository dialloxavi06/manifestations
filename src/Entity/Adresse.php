<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdresseRepository::class)]
class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $numero = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_rue = null;

    #[ORM\Column(length: 255)]
    private ?string $code_postal = null;

    /**
     * @var Collection<int, Kontakt>
     */
    #[ORM\OneToMany(mappedBy: 'adresse', targetEntity: Kontakt::class)]
    private Collection $kontakt;

    public function __construct()
    {
        $this->kontakt = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(?int $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getNomRue(): ?string
    {
        return $this->nom_rue;
    }

    public function setNomRue(string $nom_rue): static
    {
        $this->nom_rue = $nom_rue;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): static
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    /**
     * @return Collection<int, Kontakt>
     */
    public function getKontakt(): Collection
    {
        return $this->kontakt;
    }

    public function addKontakt(Kontakt $kontakt): static
    {
        if (!$this->kontakt->contains($kontakt)) {
            $this->kontakt->add($kontakt);
            $kontakt->setAdresse($this);
        }

        return $this;
    }

    public function removeKontakt(Kontakt $kontakt): static
    {
        if ($this->kontakt->removeElement($kontakt)) {
            // set the owning side to null (unless already changed)
            if ($kontakt->getAdresse() === $this) {
                $kontakt->setAdresse(null);
            }
        }

        return $this;
    }
}
