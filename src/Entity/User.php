<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ExclusionPolicy("all")
 * @ORM\HasLifecycleCallbacks()
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"users_show_client_list"})
     * @Expose
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Expose
     */
    private $client;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     * @Groups({"users_show_client_list", "user_show_detail"})
     * @Expose
     */
    private $createdAt;

    /**
     * @Serializer\Type("App\Entity\Address")
     * @ORM\ManyToOne(targetEntity=Address::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"user_show_detail"})
     * @Expose
     */
    private $address;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_show_detail", "users_show_client_list"})
     * @Expose
     */
    private $firstName;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_show_detail", "users_show_client_list"})
     * @Expose
     */
    private $lastName;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_show_detail", "users_show_client_list"})
     * @Expose
     */
    private $mailAddress;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Groups({"user_show_detail"})
     * @Expose
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
