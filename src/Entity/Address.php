<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Serializer\Type("integer")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $number;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $adverb;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=255)
     */
    private $street;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string")
     */
    private $postal;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=255)
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
