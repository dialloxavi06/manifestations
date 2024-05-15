<?php

namespace App\Entity;

use App\Repository\InstitutionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstitutionRepository::class)]
class Institution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'institutions')]
    private ?TypeInstitution $type_institution = null;

    /**
     * @var Collection<int, Kontakt>
     */
    #[ORM\ManyToMany(targetEntity: Kontakt::class, mappedBy: 'institution')]
    private Collection $kontakts;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    public function __construct()
    {
        $this->kontakts = new ArrayCollection();
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

    public function getTypeInstitution(): ?TypeInstitution
    {
        return $this->type_institution;
    }

    public function setTypeInstitution(?TypeInstitution $type_institution): static
    {
        $this->type_institution = $type_institution;

        return $this;
    }

    /**
     * @return Collection<int, Kontakt>
     */
    public function getKontakts(): Collection
    {
        return $this->kontakts;
    }

    public function addKontakt(Kontakt $kontakt): static
    {
        if (!$this->kontakts->contains($kontakt)) {
            $this->kontakts->add($kontakt);
            $kontakt->addInstitution($this);
        }

        return $this;
    }

    public function removeKontakt(Kontakt $kontakt): static
    {
        if ($this->kontakts->removeElement($kontakt)) {
            $kontakt->removeInstitution($this);
        }

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }
}
