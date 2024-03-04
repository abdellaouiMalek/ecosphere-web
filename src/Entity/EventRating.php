<?php

namespace App\Entity;

use App\Repository\EventRatingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRatingRepository::class)]
class EventRating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $rating = null;

    #[ORM\ManyToOne(inversedBy: 'eventRatings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $event = null;

    public function getId(): ?int
    {
        return $this->id;
    } 

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }
}
