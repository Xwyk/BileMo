<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"products_show_list"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     * @Groups({"products_show_list", "product_show_detail"})
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=32)
     * @Groups({"products_show_list", "product_show_detail"})
     */
    private $commercialName;

    /**
     * @ORM\Column(type="string", length=32)
     * @Groups({"products_show_list", "product_show_detail"})
     */
    private $model;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"products_show_list", "product_show_detail"})
     */
    private $rom;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"products_show_list", "product_show_detail"})
     */
    private $ram;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"products_show_list", "product_show_detail"})
     */
    private $battery;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"products_show_list", "product_show_detail"})
     */
    private $launchedAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"products_show_list", "product_show_detail"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"products_show_list", "product_show_detail"})
     */
    private $price;



    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getCommercialName(): ?string
    {
        return $this->commercialName;
    }

    public function setCommercialName(string $commercialName): self
    {
        $this->commercialName = $commercialName;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getRom(): ?int
    {
        return $this->rom;
    }

    public function setRom(int $rom): self
    {
        $this->rom = $rom;

        return $this;
    }

    public function getRam(): ?int
    {
        return $this->ram;
    }

    public function setRam(int $ram): self
    {
        $this->ram = $ram;

        return $this;
    }

    public function getBattery(): ?int
    {
        return $this->battery;
    }

    public function setBattery(int $battery): self
    {
        $this->battery = $battery;

        return $this;
    }

    public function getLaunchedAt(): ?\DateTimeInterface
    {
        return $this->launchedAt;
    }

    public function setLaunchedAt(\DateTimeInterface $launchedAt): self
    {
        $this->launchedAt = $launchedAt;

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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }
}
