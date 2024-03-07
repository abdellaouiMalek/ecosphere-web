<?php

namespace App\Entity;

use App\Repository\ObjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ObjetRepository::class)]

class Objet
{   /**
    * @Groups("objets")
    */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    /**
     * @Assert\NotBlank(message="Type ne doit pas être vide.")
    */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Type = null;
    /**
     * @Groups("objets")
     *
    */
    

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Picture = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $upload= null;
    
  /**
     * @ORM\Column
     * @Assert\Type(type="integer", message="L'âge doit être un nombre entier")
     * @Assert\GreaterThan(value=0, message="L'âge doit être supérieur à zéro")
     */
   
    #[ORM\Column(nullable: true)]
    private ?int $Age = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $historique = null;

    #[ORM\Column(length: 255, nullable: true)]
     /**
     * @Assert\NotBlank(message="La description ne doit pas être vide.")
     * @Assert\Type("string", message="La valeur {{ value }} n'est pas une chaîne de caractères valide.")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "La description ne doit pas dépasser {{ limit }} caractères."
     * )
     * @Groups("objets")
     */
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'Objet', targetEntity: Historique::class)]
    private Collection $Historique;


    /**
     * @ORM\Column
     * @Assert\Type(type="integer", message="Le prix doit être un nombre entier")
     * @Assert\GreaterThan(value=0, message="Le prix doit être supérieur à zéro")
     */
    #[ORM\Column(nullable: true)]
    private ?int $prix = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $history = null;

    #[ORM\Column(length: 255, nullable: true)]
    /**
     * @Assert\NotBlank(message="nom ne doit pas être vide.")
     * @Assert\Type("string", message="La valeur {{ value }} n'est pas une chaîne de caractères valide.")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "nom ne doit pas dépasser {{ limit }} caractères."
     * )

     
    */
    private ?string $nom = null;

    public function __construct()
    {
        $this->Historique = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setupload(string $upload): static
    {
        $this->upload = $upload;

        return $this;
    }
    public function getupload(): ?string
    {
        return $this->upload;
    }    
 

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): static
    {
        $this->Type = $Type;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->Picture;
    }

    public function setPicture(string $Picture): static
    {
        $this->Picture = $Picture;

        return $this;
    }


    public function getAge(): ?int
    {
        return $this->Age;
    }

    public function setAge(int $Age): static
    {
        $this->Age = $Age;

        return $this;
    }

    public function getHistorique(): ?string
    {
        return $this->historique;
    }

    public function setHistorique(string $historique): static
    {
        $this->historique = $historique;

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

    public function getNom_o(): ?string
    {
        return $this->nom_o;
    }

    public function setNom_o(string $nom_o): static
    {
        $this->nom_o = $nom_o;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }
}
