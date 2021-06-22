<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\NotNull;
use OpenApi\Annotations as OA;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 * @ExclusionPolicy("all")
 * @UniqueEntity(
 *     fields={"siren, siret, tva"},
 * )
 * @OA\Schema (description="Direct client of application. Allow to view/create/delete users and view products")
 */
class Client implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Expose
     * @var in
     * @OA\Property(description="Unique identifier of Client")
     */
    private $id;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=32)
     * @Expose
     * @var string
     * @OA\Property(description="Clients's name", example="1979")
     */
    private $name;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     * @var string
     * @OA\Property(description="Clients's Description", example="1979, société par actions simplifiée est active depuis 41 ans. Localisée à PARIS (75016), elle est spécialisée dans le secteur d'activité de l'edition et distribution vidéo. Son effectif est compris entre 50 et 99 salariés. Sur l'année 2019 elle réalise un chiffre d'affaires de 20 029 000,00 €. Le total du bilan a augmenté de 9,82 % entre 2018 et 2019. Societe.com recense 6 établissements et le dernier événement notable de cette entreprise date du 20-05-2020. Gregory DORCEL, est président de la société 1979.")
     */
    private $description;

    /**
     * @Serializer\Type("DateTime<'Y-m-d', '', ['Y-m-d', 'Y/m/d']>")
     * @ORM\Column(type="datetime")
     * @Expose
     * @var DateTime
     * @OA\Property(description="Clients's creation date (not in database)", example="1979-01-01")
     */
    private $createdAt;

    /**
     * @Serializer\Type("array<App\Entity\User>")
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="client", orphanRemoval=true, cascade={"persist"})
     * @Expose
     * @var Collection
     * @OA\Property(description="Client's users list")
     */
    private $users;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", unique=true, length=255)
     * @Expose
     * @var string
     * @OA\Property(description="Client's username")
     */
    private $username;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=255)
     * @Expose
     * @var string
     * @OA\Property(description="Client's password")
     */
    private $password;

    /**
     * @Serializer\Type("App\Entity\Address")
     * @ORM\ManyToOne(targetEntity=Address::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Expose
     * @var Address
     * @OA\Property(description="Client's address")
     */
    private $address;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=14)
     * @Expose
     * @var string
     * @OA\Property(description="Client's siret", example="31638830500062")
     */
    private $siret;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=9)
     * @Expose
     * @var string
     * @OA\Property(description="Client's siret", example="316388305")
     */
    private $siren;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=13)
     * @Expose
     * @var string
     * @OA\Property(description="Client's siret", example="FR42316388305")
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
