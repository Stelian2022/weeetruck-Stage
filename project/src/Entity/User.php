<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: false)]
    private ?string $nom = null;


  

    #[ORM\Column(length: 180, unique: false)]
    private ?string $prenom = null;



    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Missions::class)]
    private Collection $mission_id;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Ticket::class)]
    private Collection $ticket_id;

    public function __construct()
    {
        $this->mission_id = new ArrayCollection();
        $this->ticket_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_EMPLOYE
        $roles[] = 'ROLE_EMPLOYE';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    public function __toString(): string
{
    return $this->getEmail();
}

    /**
     * @return Collection<int, Missions>
     */
    public function getMissionId(): Collection
    {
        return $this->mission_id;
    }

    public function addMissionId(Missions $missionId): static
    {
        if (!$this->mission_id->contains($missionId)) {
            $this->mission_id->add($missionId);
            $missionId->setUser($this);
        }

        return $this;
    }

    public function removeMissionId(Missions $missionId): static
    {
        if ($this->mission_id->removeElement($missionId)) {
            // set the owning side to null (unless already changed)
            if ($missionId->getUser() === $this) {
                $missionId->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTicketId(): Collection
    {
        return $this->ticket_id;
    }

    public function addTicketId(Ticket $ticketId): static
    {
        if (!$this->ticket_id->contains($ticketId)) {
            $this->ticket_id->add($ticketId);
            $ticketId->setUser($this);
        }

        return $this;
    }

    public function removeTicketId(Ticket $ticketId): static
    {
        if ($this->ticket_id->removeElement($ticketId)) {
            // set the owning side to null (unless already changed)
            if ($ticketId->getUser() === $this) {
                $ticketId->setUser(null);
            }
        }

        return $this;
    }

}
