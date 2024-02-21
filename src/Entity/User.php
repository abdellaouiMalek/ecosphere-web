<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private ?float $phoneNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\OneToMany(targetEntity: Carpooling::class, mappedBy: 'user')]
    private Collection $carpooling;

    #[ORM\ManyToMany(targetEntity: Store::class, inversedBy: 'users')]
    private Collection $store;

    #[ORM\ManyToMany(targetEntity: Event::class, inversedBy: 'users')]
    private Collection $event;

    #[ORM\OneToMany(targetEntity: BlogPost::class, mappedBy: 'user')]
    private Collection $blogPost;

    #[ORM\OneToMany(targetEntity: ReusableObject::class, mappedBy: 'user')]
    private Collection $reusableObject;

    #[ORM\OneToMany(targetEntity: EventRegistrations::class, mappedBy: 'user')]
    private Collection $eventRegistrations;

    public function __construct()
    {
        $this->carpooling = new ArrayCollection();
        $this->store = new ArrayCollection();
        $this->event = new ArrayCollection();
        $this->blogPost = new ArrayCollection();
        $this->reusableObject = new ArrayCollection();
        $this->eventRegistrations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPhoneNumber(): ?float
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(float $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, Carpooling>
     */
    public function getCarpooling(): Collection
    {
        return $this->carpooling;
    }

    public function addCarpooling(Carpooling $carpooling): static
    {
        if (!$this->carpooling->contains($carpooling)) {
            $this->carpooling->add($carpooling);
            $carpooling->setUser($this);
        }

        return $this;
    }

    public function removeCarpooling(Carpooling $carpooling): static
    {
        if ($this->carpooling->removeElement($carpooling)) {
            // set the owning side to null (unless already changed)
            if ($carpooling->getUser() === $this) {
                $carpooling->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Store>
     */
    public function getStore(): Collection
    {
        return $this->store;
    }

    public function addStore(Store $store): static
    {
        if (!$this->store->contains($store)) {
            $this->store->add($store);
        }

        return $this;
    }

    public function removeStore(Store $store): static
    {
        $this->store->removeElement($store);

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvent(): Collection
    {
        return $this->event;
    }

    public function addEvent(Event $event): static
    {
        if (!$this->event->contains($event)) {
            $this->event->add($event);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        $this->event->removeElement($event);

        return $this;
    }

    /**
     * @return Collection<int, BlogPost>
     */
    public function getBlogPost(): Collection
    {
        return $this->blogPost;
    }

    public function addBlogPost(BlogPost $blogPost): static
    {
        if (!$this->blogPost->contains($blogPost)) {
            $this->blogPost->add($blogPost);
            $blogPost->setUser($this);
        }

        return $this;
    }

    public function removeBlogPost(BlogPost $blogPost): static
    {
        if ($this->blogPost->removeElement($blogPost)) {
            // set the owning side to null (unless already changed)
            if ($blogPost->getUser() === $this) {
                $blogPost->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ReusableObject>
     */
    public function getReusableObject(): Collection
    {
        return $this->reusableObject;
    }

    public function addReusableObject(ReusableObject $reusableObject): static
    {
        if (!$this->reusableObject->contains($reusableObject)) {
            $this->reusableObject->add($reusableObject);
            $reusableObject->setUser($this);
        }

        return $this;
    }

    public function removeReusableObject(ReusableObject $reusableObject): static
    {
        if ($this->reusableObject->removeElement($reusableObject)) {
            // set the owning side to null (unless already changed)
            if ($reusableObject->getUser() === $this) {
                $reusableObject->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EventRegistrations>
     */
    public function getEventRegistrations(): Collection
    {
        return $this->eventRegistrations;
    }

    public function addEventRegistration(EventRegistrations $eventRegistration): static
    {
        if (!$this->eventRegistrations->contains($eventRegistration)) {
            $this->eventRegistrations->add($eventRegistration);
            $eventRegistration->setUser($this);
        }

        return $this;
    }

    public function removeEventRegistration(EventRegistrations $eventRegistration): static
    {
        if ($this->eventRegistrations->removeElement($eventRegistration)) {
            // set the owning side to null (unless already changed)
            if ($eventRegistration->getUser() === $this) {
                $eventRegistration->setUser(null);
            }
        }

        return $this;
    }
        // Implement the __toString() method
        public function __toString()
        {
            return $this->getId(); // Assuming getUsername() returns the username
        }
    
}
