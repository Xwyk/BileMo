<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use OpenApi\Annotations as OA;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 * @ExclusionPolicy("all")
 * @UniqueEntity(
 *     fields={"siren, siret, tva"},
 * )
 * @OA\Schema
 */
class Client implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Expose
     */
    private $id;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=32)
     * @Expose
     */
    private $name;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     */
    private $description;

    /**
     * @Serializer\Type("DateTime")
     * @ORM\Column(type="datetime")
     * @Expose
     */
    private $createdAt;

    /**
     * @Serializer\Type("array<App\Entity\User>")
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="client", orphanRemoval=true, cascade={"persist"})
     * @Expose
     */
    private $users;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", unique=true, length=255)
     * @Expose
     */
    private $username;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=255)
     * @Expose
     */
    private $password;

    /**
     * @Serializer\Type("App\Entity\Address")
     * @ORM\ManyToOne(targetEntity=Address::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Expose
     */
    private $address;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=14)
     * @Expose
     */
    private $siret;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=9)
     * @Expose
     */
    private $siren;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=13)
     * @Expose
     */
    private $tva;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers()
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setClient($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getClient() === $this) {
                $user->setClient(null);
            }
        }

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getSiret(): ?int
    {
        return $this->siret;
    }

    public function setSiret(int $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getSiren(): ?int
    {
        return $this->siren;
    }

    public function setSiren(int $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    public function getTva(): ?string
    {
        return $this->tva;
    }

    public function setTva(string $tva): self
    {
        $this->tva = $tva;
        return $this;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}
