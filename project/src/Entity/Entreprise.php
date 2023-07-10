<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
#[ORM\Table(name: '`entreprise`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Entreprise implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $nom = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: Devis::class)]
    private Collection $devis_id;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: Ticket::class)]
    private Collection $ticket_id;

    public function __construct()
    {
        $this->devis_id = new ArrayCollection();
        $this->ticket_id = new ArrayCollection();
    }

    
    public function getId(): ?int
    {
        return $this->id;
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
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_ENTREPRISE';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
      
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

    /**
     * @return Collection<int, Devis>
     */
    public function getDevisId(): Collection
    {
        return $this->devis_id;
    }

    public function addDevisId(Devis $devisId): static
    {
        if (!$this->devis_id->contains($devisId)) {
            $this->devis_id->add($devisId);
            $devisId->setEntreprise($this);
        }

        return $this;
    }

    public function removeDevisId(Devis $devisId): static
    {
        if ($this->devis_id->removeElement($devisId)) {
            // set the owning side to null (unless already changed)
            if ($devisId->getEntreprise() === $this) {
                $devisId->setEntreprise(null);
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
            $ticketId->setEntreprise($this);
        }

        return $this;
    }

    public function removeTicketId(Ticket $ticketId): static
    {
        if ($this->ticket_id->removeElement($ticketId)) {
            // set the owning side to null (unless already changed)
            if ($ticketId->getEntreprise() === $this) {
                $ticketId->setEntreprise(null);
            }
        }

        return $this;
    }
}
