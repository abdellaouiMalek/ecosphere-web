<?php

namespace App\Entity;

use App\Repository\HistoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoryRepository::class)]
class History
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $innitialCondition = null;

    #[ORM\Column(length: 255)]
    private ?string $arrivalState = null;

    #[ORM\OneToOne(mappedBy: 'history', cascade: ['persist', 'remove'])]
    private ?ReusableObject $reusableObject = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInnitialCondition(): ?string
    {
        return $this->innitialCondition;
    }

    public function setInnitialCondition(string $innitialCondition): static
    {
        $this->innitialCondition = $innitialCondition;

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

    public function getReusableObject(): ?ReusableObject
    {
        return $this->reusableObject;
    }

    public function setReusableObject(ReusableObject $reusableObject): static
    {
        // set the owning side of the relation if necessary
        if ($reusableObject->getHistory() !== $this) {
            $reusableObject->setHistory($this);
        }

        $this->reusableObject = $reusableObject;

        return $this;
    }
}
