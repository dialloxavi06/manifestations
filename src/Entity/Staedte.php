<?php

namespace App\Entity;

use App\Repository\StaedteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups as AttributeGroups;

#[ORM\Entity(repositoryClass: StaedteRepository::class)]
class Staedte
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



    #[ORM\ManyToOne(inversedBy: 'staedtes')]
    private ?Countries $pays = null;



    /**
     * @var Collection<int, Manifestation>
     */
    #[ORM\ManyToMany(targetEntity: Manifestation::class, mappedBy: 'staedte')]
    private Collection $veranstaltungen;

    public function __construct()
    {

        $this->veranstaltungen = new ArrayCollection();
    }


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




    public function getPays(): ?Countries
    {
        return $this->pays;
    }

    public function setPays(?Countries $pays): static
    {
        $this->pays = $pays;

        return $this;
    }


    /**
     * @return Collection<int, Manifestation>
     */
    public function getVeranstaltungen(): Collection
    {
        return $this->veranstaltungen;
    }

    public function addVeranstaltungen(Manifestation $veranstaltungen): static
    {
        if (!$this->veranstaltungen->contains($veranstaltungen)) {
            $this->veranstaltungen->add($veranstaltungen);
            $veranstaltungen->addStaedte($this);
        }

        return $this;
    }

    public function removeVeranstaltungen(Manifestation $veranstaltungen): static
    {
        if ($this->veranstaltungen->removeElement($veranstaltungen)) {
            $veranstaltungen->removeStaedte($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }
}
