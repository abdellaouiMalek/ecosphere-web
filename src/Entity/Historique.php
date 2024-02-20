<?php

namespace App\Entity;

use App\Repository\HistoriqueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HistoriqueRepository::class)]
class Historique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $initialCondition = null;

    #[ORM\Column(length: 255)]
    private ?string $arrivalState = null;

    #[ORM\ManyToOne(inversedBy: 'Historique')]
    private ?Objet $objet = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }
}
