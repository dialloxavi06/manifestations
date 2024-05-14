<?php

namespace App\Entity;

use App\Repository\KontaktRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KontaktRepository::class)]
class Kontakt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telefone = null;

    #[ORM\ManyToOne(inversedBy: 'Kontakt')]
    private ?Role $role = null;

    /**
     * @var Collection<int, Project>
     */
    #[ORM\ManyToMany(targetEntity: Project::class, inversedBy: 'Kontakt')]
    private Collection $projet;

    #[ORM\OneToOne(mappedBy: 'kontakt', cascade: ['persist', 'remove'])]
    private ?Utilisateur $utilisateur = null;

    /**
     * @var Collection<int, Project>
     */
    #[ORM\ManyToMany(targetEntity: Project::class, mappedBy: 'kontakt')]
    private Collection $projects;

    /**
     * @var Collection<int, Institution>
     */
    #[ORM\ManyToMany(targetEntity: Institution::class, inversedBy: 'kontakts')]
    private Collection $institution;

    public function __construct()
    {
        $this->projet = new ArrayCollection();
        $this->projects = new ArrayCollection();
        $this->institution = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelefone(): ?string
    {
        return $this->telefone;
    }

    public function setTelefone(?string $telefone): self
    {
        $this->telefone = $telefone;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjet(): Collection
    {
        return $this->projet;
    }

    public function addProjet(Project $projet): static
    {
        if (!$this->projet->contains($projet)) {
            $this->projet->add($projet);
        }

        return $this;
    }

    public function removeProjet(Project $projet): static
    {
        $this->projet->removeElement($projet);

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        // unset the owning side of the relation if necessary
        if ($utilisateur === null && $this->utilisateur !== null) {
            $this->utilisateur->setKontakt(null);
        }

        // set the owning side of the relation if necessary
        if ($utilisateur !== null && $utilisateur->getKontakt() !== $this) {
            $utilisateur->setKontakt($this);
        }

        $this->utilisateur = $utilisateur;

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
            $project->addKontakt($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            $project->removeKontakt($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Institution>
     */
    public function getInstitution(): Collection
    {
        return $this->institution;
    }

    public function addInstitution(Institution $institution): static
    {
        if (!$this->institution->contains($institution)) {
            $this->institution->add($institution);
        }

        return $this;
    }

    public function removeInstitution(Institution $institution): static
    {
        $this->institution->removeElement($institution);

        return $this;
    }
}
