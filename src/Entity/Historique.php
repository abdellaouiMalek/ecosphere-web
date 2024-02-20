<?php

namespace App\Entity;

use App\Repository\HistoriqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoriqueRepository::class)]
class Historique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $id_h = null;

    #[ORM\Column(length: 255)]
    private ?string $initialCondition = null;

    #[ORM\Column(length: 255)]
    private ?string $arrivalState = null;

    #[ORM\ManyToOne(inversedBy: 'Historique')]
    private ?Objet $objet = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdH(): ?string
    {
        return $this->id_h;
    }

    public function setIdH(string $id_h): static
    {
        $this->id_h = $id_h;

        return $this;
    }

    public function getInitialCondition(): ?string
    {
        return $this->initialCondition;
    }

    public function setInitialCondition(string $initialCondition): static
    {
        $this->initialCondition = $initialCondition;

        return $this;
    }

    public function getArrivalState(): ?string
    {
        return $this->arrivalState;
    }

    public function setArrivalState(string $arrivalState): static
    {
        $this->arrivalState = $arrivalState;

        return $this;
    }

    public function getObjet(): ?Objet
    {
        return $this->objet;
    }

    public function setObjet(?Objet $objet): static
    {
        $this->objet = $objet;

        return $this;
    }
}
