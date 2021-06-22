<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Groups;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 * @OA\Schema(description="Address object, to define residence of client or user")
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     * @OA\Property(description="Unique identifier of Address")
     */
    private $id;

    /**
     * @Serializer\Type("integer")
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"user_show_detail", "users_show_client_list", "create"})
     * @var int
     * @OA\Property(description="Number of address", example=55)
     * @Assert\Positive (groups={"create"})
     */
    private $number;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=16, nullable=true)
     * @Groups({"user_show_detail", "users_show_client_list", "create"})
     * @var string
     * @OA\Property(description="Adverb (bis, ter ...)")
     */
    private $adverb;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_show_detail", "users_show_client_list", "create"})
     * @var string
     * @OA\Property(description="Street of address", example="Rue du Faubourg Saint-Honoré")
     * @Assert\NotBlank(groups={"create"})
     * @Assert\NotNull (groups={"create"})
     */
    private $street;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string")
     * @Groups({"user_show_detail", "users_show_client_list", "create"})
     * @var string
     * @OA\Property(description="Postal code of address", example="75008")
     * @Assert\NotBlank(groups={"create"})
     * @Assert\NotNull (groups={"create"})
     */
    private $postal;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_show_detail", "users_show_client_list", "create"})
     * @var string
     * @OA\Property(description="City of residence", example="Paris")
     * @Assert\NotBlank(groups={"create"})
     * @Assert\NotNull (groups={"create"})
     */
    private $city;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_show_detail", "users_show_client_list", "create"})
     * @var string
     * @OA\Property(description="Country of residence", example="France")
     * @Assert\NotBlank(groups={"create"})
     * @Assert\NotNull(groups={"create"})
     */
    private $country;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(?int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getAdverb(): ?string
    {
        return $this->adverb;
    }

    public function setAdverb(?string $adverb): self
    {
        $this->adverb = $adverb;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getPostal(): ?int
    {
        return $this->postal;
    }

    public function setPostal(int $postal): self
    {
        $this->postal = $postal;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }
}
