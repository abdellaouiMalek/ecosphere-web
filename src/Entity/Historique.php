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
       /**
     * @Assert\NotBlank(message=" le nom doit etre non vide")
    *@Assert\Type("string",message="The value {{ value }} is not a valid {{ type }}.")
    */
    private ?string $nom_O = null;

    #[ORM\Column(length: 255)]
    private ?string $initialCondition = null;

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

    public function getNomO(): ?string
    {
        return $this->nom_O;
    }

    public function setNomO(string $nom_O): static
    {
        $this->nom_O = $nom_O;

        return $this;
    }
}
