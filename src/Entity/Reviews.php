<?php

namespace App\Entity;

use App\Repository\ReviewsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewsRepository::class)]
class Reviews
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $user_name = null;

    #[ORM\Column]
    private ?int $user_rating = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $user_review = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    private ?Event $event = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $created_date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->user_name;
    }

    public function setUserName(string $user_name): static
    {
        $this->user_name = $user_name;

        return $this;
    }

    public function getUserRating(): ?int
    {
        return $this->user_rating;
    }

    public function setUserRating(int $user_rating): static
    {
        $this->user_rating = $user_rating;

        return $this;
    }

    public function getUserReview(): ?string
    {
        return $this->user_review;
    }

    public function setUserReview(?string $user_review): static
    {
        $this->user_review = $user_review;

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

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->created_date;
    }

    public function setCreatedDate(?\DateTimeInterface $created_date): static
    {
        $this->created_date = $created_date;

        return $this;
    }
}
