<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $num_dossier = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titreFr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titreDe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titreEn = null;

    #[ORM\OneToMany(targetEntity: Manifestation::class, mappedBy: 'project')]
    private Collection $manifestations;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    private ?TypeProject $type_project = null;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    private ?Status $status_project = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $motif_annulation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $justification_annulation = null;

    #[ORM\ManyToOne(inversedBy: 'projects', cascade: ['persist'])]
    private ?Discipline $discipline = null;

    /**
     * @var Collection<int, Kontakt>
     */
    #[ORM\ManyToMany(targetEntity: Kontakt::class, inversedBy: 'projects')]
    private Collection $kontakt;

    public function __construct()
    {
        $this->manifestations = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->kontakt = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumDossier(): ?string
    {
        return $this->num_dossier;
    }

    public function setNumDossier(string $num_dossier): static
    {
        $this->num_dossier = $num_dossier;

        return $this;
    }

    public function getTitreFr(): ?string
    {
        return $this->titreFr;
    }

    public function setTitreFr(?string $titre): static
    {
        $this->titreFr = $titre;

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
            $manifestation->setProject($this);
        }

        return $this;
    }

    public function removeManifestation(Manifestation $manifestation): static
    {
        if ($this->manifestations->removeElement($manifestation)) {
            // set the owning side to null (unless already changed)
            if ($manifestation->getProject() === $this) {
                $manifestation->setProject(null);
            }
        }

        return $this;
    }



    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }


    public function getTitreDe(): ?string
    {
        return $this->titreDe;
    }

    public function setTitreDe(?string $titreDe): static
    {
        $this->titreDe = $titreDe;

        return $this;
    }

    public function getTitreEn(): ?string
    {
        return $this->titreEn;
    }

    public function setTitreEn(?string $titreEn): static
    {
        $this->titreEn = $titreEn;

        return $this;
    }

    public function getTypeProject(): ?TypeProject
    {
        return $this->type_project;
    }

    public function setTypeProject(?TypeProject $type_project): static
    {
        $this->type_project = $type_project;

        return $this;
    }

    public function getStatusProject(): ?Status
    {
        return $this->status_project;
    }

    public function setStatusProject(?Status $status_project): static
    {
        $this->status_project = $status_project;

        return $this;
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

    public function getJustificationAnnulation(): ?string
    {
        return $this->justification_annulation;
    }

    public function setJustificationAnnulation(?string $justification_annulation): static
    {
        $this->justification_annulation = $justification_annulation;

        return $this;
    }

    public function getMoisCreatedAt(): ?string
    {
        $moisCreatedAt = $this->createdAt->format('m');
        return $moisCreatedAt;
    }

    public function getDiscipline(): ?Discipline
    {
        return $this->discipline;
    }

    public function setDiscipline(?Discipline $discipline): static
    {
        $this->discipline = $discipline;

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
        }

        return $this;
    }

    public function removeKontakt(Kontakt $kontakt): static
    {
        $this->kontakt->removeElement($kontakt);

        return $this;
    }
}
