<?php

namespace App\Entity;

use App\Repository\ManifestationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;




#[ORM\Entity(repositoryClass: ManifestationRepository::class)]
class Manifestation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titreFr = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titreDe = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titreEn = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_debut = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_fin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $duree = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Gedmo\Translatable]
    private ?string $justification_duree = null;

    #[ORM\ManyToOne(inversedBy: 'manifestations')]
    private ?Project $project_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    private ?string $ville = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pays = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $justification_pays_tiers = null;

    /**
     * @var Collection<int, PaysTiers>
     */
    #[ORM\OneToMany(mappedBy: 'manifestation', targetEntity: PaysTiers::class)]
    private Collection $paysTiers;

    public function __construct()
    {
        $this->paysTiers = new ArrayCollection();
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

    public function getProjectId(): ?Project
    {
        return $this->project_id;
    }

    public function setProjectId(?Project $project_id): static
    {
        $this->project_id = $project_id;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): static
    {
        $this->ville = $ville;

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


    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Collection<int, PaysTiers>
     */
    public function getPaysTiers(): Collection
    {
        return $this->paysTiers;
    }

    public function addPaysTier(PaysTiers $paysTier): static
    {
        if (!$this->paysTiers->contains($paysTier)) {
            $this->paysTiers->add($paysTier);
            $paysTier->setManifestation($this);
        }

        return $this;
    }

    public function removePaysTier(PaysTiers $paysTier): static
    {
        if ($this->paysTiers->removeElement($paysTier)) {
            // set the owning side to null (unless already changed)
            if ($paysTier->getManifestation() === $this) {
                $paysTier->setManifestation(null);
            }
        }

        return $this;
    }
}
