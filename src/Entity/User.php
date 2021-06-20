<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ExclusionPolicy("all")
 * @ORM\HasLifecycleCallbacks()
 * @OA\Schema(
 *     description="Define client's client. An user is a client of app client (Client class). B2B model",
 * )
 * @Hateoas\Relation(
 *     "self",
 *     href = @Hateoas\Route(
 *         "app_user_show_details",
 *         parameters = {"userId"="expr(object.getId())"},
 *         absolute = true
 *     ),
 *     exclusion = @Hateoas\Exclusion(groups={"users_show_client_list"})
 * )
 *
 * @Hateoas\Relation(
 *     "delete",
 *     href = @Hateoas\Route(
 *         "app_client_del_user",
 *         parameters = {"userId"="expr(object.getId())"},
 *         absolute = true
 *     ),
 *     exclusion = @Hateoas\Exclusion(groups={"users_show_client_list", "user_show_detail"})
 * )
 *
 * @Hateoas\Relation(
 *     "create",
 *     href = @Hateoas\Route(
 *         "app_client_add_user",
 *         absolute = true
 *     ),
 *     exclusion = @Hateoas\Exclusion(groups={"users_show_client_list", "user_show_detail"})
 * )
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"users_show_client_list"})
     * @Expose
     * @var int
     * @OA\Property(description="Unique identifier of User")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"nodisplay"})
     * @Expose
     * @var Client
     * @OA\Property(description="User's client")
     */
    private $client;

    /**
     * @Serializer\Type("DateTime<'Y-m-d', '', ['Y-m-d', 'Y/m/d']>")
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     * @Groups({"users_show_client_list", "user_show_detail"})
     * @Expose
     * @var DateTime
     * @OA\Property(description="User's creation date", example="2021-06-19T08:37:42+00:00")
     */
    private $createdAt;

    /**
     * @Serializer\Type("App\Entity\Address")
     * @ORM\ManyToOne(targetEntity=Address::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"user_show_detail", "create"})
     * @Expose
     * @var Address
     * @OA\Property(description="User's address")
     */
    private $address;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_show_detail", "users_show_client_list", "create"})
     * @Expose
     * @var string
     * @OA\Property(description="User's first name", example="Florian")
     */
    private $firstName;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_show_detail", "users_show_client_list", "create"})
     * @Expose
     * @var string
     * @OA\Property(description="User's last name", example="LEBOUL")
     */
    private $lastName;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_show_detail", "users_show_client_list", "create"})
     * @Expose
     * @var string
     * @OA\Property(description="User's mail address", example="florianleboul@gmail.com")
     */
    private $mailAddress;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Groups({"user_show_detail", "create"})
     * @Expose
     * @var string
     * @OA\Property(description="User's phone number", example="06 05 41 06 16")
     */
    private $phone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

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

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePerist()
    {
        $this->createdAt = new \DateTime();
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getMailAddress(): ?string
    {
        return $this->mailAddress;
    }

    public function setMailAddress(string $mailAddress): self
    {
        $this->mailAddress = $mailAddress;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(?int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
