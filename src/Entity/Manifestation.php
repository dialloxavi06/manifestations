<?php

namespace App\Entity;

use App\Repository\ManifestationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ManifestationRepository::class)]
class Manifestation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_debut = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_fin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $duree = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $justification_duree = null; 

    #[ORM\ManyToOne(inversedBy: 'manifestations')]
    private ?Project $project_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pays_tiers = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pays = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $justification_pays_tiers = null;

    #[ORM\ManyToOne(inversedBy: 'manifestations')]
    private ?Ville $ville = null;

    public function __construct()
    {    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeImmutable
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeImmutable $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeImmutable
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeImmutable $date_fin): static
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(?string $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getJustificationDuree(): ?string
    {
        return $this->justification_duree;
    }

    public function setJustificationDuree(?string $justification_duree): static
    {
        $this->justification_duree = $justification_duree;

        return $this;
    }

    public function getProjectId(): ?Project
    {
        return $this->project_id;
    }

    public function setProjectId(?Project $project_id): static
    {
        $this->project_id = $project_id;

        return $this;
    }



    public function getPaysTiers(): ?string
    {
        return $this->pays_tiers;
    }

    public function setPaysTiers(?string $pays_tiers): static
    {
        $this->pays_tiers = $pays_tiers;

        return $this;
    }

    public function getJustificationPaysTiers(): ?string
    {
        return $this->justification_pays_tiers;
    }

    public function setJustificationPaysTiers(?string $justification_pays_tiers): static
    {
        $this->justification_pays_tiers = $justification_pays_tiers;

        return $this;
    }


public function getVille(): ?Ville
{
    return $this->ville;
}

public function setVille(?Ville $ville): static
{
    $this->ville = $ville;

    return $this;

}

public function getPays(): ?string
{
    return $this->pays; 
}

public function setPays(?Pays $pays): static
{
    $this->pays = $pays;

    return $this;
}

}
