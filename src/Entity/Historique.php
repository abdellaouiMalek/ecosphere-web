<?php

namespace App\Entity;
use DateTimeInterface;
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
    private ?string $nom_o = null;

    #[ORM\Column(length: 255)]
    private ?string $initialCondition = null;

    #[ORM\ManyToOne(inversedBy: 'Historique')]
    private ?Objet $objet = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    /**
     * @ORM\Column(type="datetime")
     */
    private $date;
    


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

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
    public function getNomo(): ?string
    {
        return $this->nom_o;
    }

    public function setNomo(string $nom_o): static
    {
        $this->nom_o = $nom_o;

        return $this;
    }


}
