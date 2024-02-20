<?php

namespace App\Entity;

use App\Repository\ObjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ObjetRepository::class)]
class Objet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $id_o = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $picture = null;

    #[ORM\Column]
    private ?int $age = null;

    #[ORM\Column(length: 255)]
    private ?string $history = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $type_o = null;

    #[ORM\OneToMany(targetEntity: Historique::class, mappedBy: 'objet')]
    private Collection $Historique;

    public function __construct()
    {
        $this->Historique = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdO(): ?string
    {
        return $this->id_o;
    }

    public function setIdO(string $id_o): static
    {
        $this->id_o = $id_o;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getHistory(): ?string
    {
        return $this->history;
    }

    public function setHistory(string $history): static
    {
        $this->history = $history;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getTypeO(): ?string
    {
        return $this->type_o;
    }

    public function setTypeO(string $type_o): static
    {
        $this->type_o = $type_o;

        return $this;
    }

    /**
     * @return Collection<int, Historique>
     */
    public function getHistorique(): Collection
    {
        return $this->Historique;
    }

    public function addHistorique(Historique $historique): static
    {
        if (!$this->Historique->contains($historique)) {
            $this->Historique->add($historique);
            $historique->setObjet($this);
        }

        return $this;
    }

    public function removeHistorique(Historique $historique): static
    {
        if ($this->Historique->removeElement($historique)) {
            // set the owning side to null (unless already changed)
            if ($historique->getObjet() === $this) {
                $historique->setObjet(null);
            }
        }

        return $this;
    }
}
