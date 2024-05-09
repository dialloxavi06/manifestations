<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
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
    #[ORM\ManyToMany(targetEntity: Manifestation::class, inversedBy: 'statuses')]
    private Collection $manifestations;

    /**
     * @var Collection<int, Project>
     */
    #[ORM\OneToMany(mappedBy: 'status_project', targetEntity: Project::class)]
    private Collection $projects;

    public function __construct()
    {
        $this->manifestations = new ArrayCollection();
        $this->projects = new ArrayCollection();
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
        }

        return $this;
    }

    public function removeManifestation(Manifestation $manifestation): static
    {
        $this->manifestations->removeElement($manifestation);

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->setStatusProject($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getStatusProject() === $this) {
                $project->setStatusProject(null);
            }
        }

        return $this;
    }
}
