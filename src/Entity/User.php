<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiResource
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ({"user_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups ({"user_read"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups ({"user_read"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ({"user_read"})
     */
    private $username;

    /**
     * @ORM\OneToMany(targetEntity=Billet::class, mappedBy="user")
     */
    private $billet_id;

    public function __construct()
    {
        $this->billet_id = new ArrayCollection();
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
    public function getUsername(): string
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
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Collection|Billet[]
     */
    public function getBilletId(): Collection
    {
        return $this->billet_id;
    }

    public function addBilletId(Billet $billetId): self
    {
        if (!$this->billet_id->contains($billetId)) {
            $this->billet_id[] = $billetId;
            $billetId->setUser($this);
        }

        return $this;
    }

    public function removeBilletId(Billet $billetId): self
    {
        if ($this->billet_id->removeElement($billetId)) {
            // set the owning side to null (unless already changed)
            if ($billetId->getUser() === $this) {
                $billetId->setUser(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        // to show the name of the Category in the select
        return $this->getUsername();
        // to show the id of the Category in the select
        // return $this->id;
    }
}
