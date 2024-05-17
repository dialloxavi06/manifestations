<?php

namespace App\Entity;

use App\Repository\ManifestationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ManifestationRepository::class)]
class Manifestation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'Veuillez renseigner le titre en français')]
    private ?string $titreFr = null;
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'Veuillez renseigner le titre en allemand')]
    private ?string $titreDe = null;
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'Veuillez renseigner le titre en anglais')]
    private ?string $titreEn = null;
    #[ORM\Column]
    #[Assert\NotBlank(message: 'Veuillez renseigner la date de début')]
    private ?\DateTimeImmutable $date_debut = null;
    #[ORM\Column]
    private ?\DateTimeImmutable $date_fin = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $duree = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $justification_duree = null;
    #[ORM\ManyToOne(inversedBy: 'manifestations')]
    private ?Project $project = null;

    /**
     * @var Collection<int, Manifestation>
     */
    #[ORM\ManyToMany(targetEntity: Countries::class, inversedBy: 'manifestations')]
    private Collection $countries;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $justification_pays_tiers = null;

    #[ORM\ManyToOne(targetEntity: Commune::class, inversedBy: 'manifs')]
    private  $commune;

    /**
     * @var Collection<int, Status>
     */
    #[ORM\ManyToMany(targetEntity: Status::class, mappedBy: 'manifestations')]
    private Collection $statuses;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $motif_annulation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description_annulation = null;


    public function __construct()
    {
        $this->duree = $this->calculateDuration();
        $this->countries = new ArrayCollection();
        $this->statuses = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreFr(): ?string
    {
        return $this->titreFr;
    }

    public function setTitreFr(string $titreFr): static
    {
        $this->titreFr = $titreFr;

        return $this;
    }

    public function getTitreDe(): ?string
    {
        return $this->titreDe;
    }

    public function setTitreDe(string $titreDe): static
    {
        $this->titreDe = $titreDe;

        return $this;
    }

    public function getTitreEn(): ?string
    {
        return $this->titreEn;
    }

    public function setTitreEn(string $titreEn): static
    {
        $this->titreEn = $titreEn;

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

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

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

    public function getCommune(): ?Commune
    {
        return $this->commune;
    }


    public function setCommune(?Commune $commune): static
    {
        $this->commune = $commune;

        return $this;
    }




    /**
     * @return Collection<int, Countries>
     */

    public function getCountries(): Collection

    {
        return $this->countries;
    }

    public function addCountry(Countries $country): static
    {
        if (!$this->countries->contains($country)) {
            $this->countries->add($country);
            $country->addManifestation($this);
        }

        return $this;
    }

    public function removeCountry(Countries $country): static
    {
        if ($this->countries->removeElement($country)) {
            $country->removeManifestation($this);
        }

        return $this;
    }


    // Méthode pour calculer la durée
    public function calculateDuration(): ?string
    {
        if ($this->date_debut && $this->date_fin) {
            $interval = $this->date_debut->diff($this->date_fin);
            return $interval->format('%a');
        }

        return null;
    }

    /**
     * @return Collection<int, Status>
     */
    public function getStatuses(): Collection
    {
        return $this->statuses;
    }

    public function addStatus(Status $status): static
    {
        if (!$this->statuses->contains($status)) {
            $this->statuses->add($status);
            $status->addManifestation($this);
        }

        return $this;
    }

    public function removeStatus(Status $status): static
    {
        if ($this->statuses->removeElement($status)) {
            $status->removeManifestation($this);
        }

        return $this;
    }


    // Dans la classe Manifestation

    public function removeAllStatus(): void
    {
        foreach ($this->statuses as $status) {
            $this->removeStatus($status);
        }
    }

    public function getMotifAnnulation(): ?string
    {
        return $this->motif_annulation;
    }

    public function setMotifAnnulation(?string $motif_annulation): static
    {
        $this->motif_annulation = $motif_annulation;

        return $this;
    }

    public function getDescriptionAnnulation(): ?string
    {
        return $this->description_annulation;
    }

    public function setDescriptionAnnulation(?string $description_annulation): static
    {
        $this->description_annulation = $description_annulation;

        return $this;
    }
}
