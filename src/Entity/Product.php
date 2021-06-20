<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @ExclusionPolicy("all")
 * @Hateoas\Relation(
 *     "self",
 *     href = @Hateoas\Route(
 *         "app_products_show_details",
 *         parameters = {"id"="expr(object.getId())"},
 *         absolute = true
 *     ),
 *     exclusion = @Hateoas\Exclusion(groups={"products_show_list"})
 * )
 * @OA\Schema(description="Mobile phone stored in database, viewable by authenticated clients")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"products_show_list"})
     * @Expose
     * @var int
     * @OA\Property(description="Unique identifier of Product")
     */
    private $id;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=32)
     * @Groups({"products_show_list", "product_show_detail"})
     * @Expose
     * @var string
     * @OA\Property(description="Phone's brand", example="Huawei")
     */
    private $brand;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=32)
     * @Groups({"products_show_list", "product_show_detail"})
     * @Expose
     * @var string
     * @OA\Property(description="Phone's commercial name", example="P20 Lite")
     */
    private $commercialName;

    /**
     * @Serializer\Type("string")
     * @ORM\Column(type="string", length=32)
     * @Groups({"products_show_list", "product_show_detail"})
     * @Expose
     * @var string
     * @OA\Property(description="Phone's model", example="ANE-LX1")
     */
    private $model;

    /**
     * @Serializer\Type("integer")
     * @ORM\Column(type="integer")
     * @Groups({"products_show_list", "product_show_detail"})
     * @Expose
     * @var int
     * @OA\Property(description="Phone's ROM memory quantity, in Go", example="64")
     */
    private $rom;

    /**
     * @Serializer\Type("integer")
     * @ORM\Column(type="integer")
     * @Groups({"products_show_list", "product_show_detail"})
     * @Expose
     * @var int
     * @OA\Property(description="Phone's RAM memory quantity, in Go", example="4")
     */
    private $ram;

    /**
     * @Serializer\Type("integer")
     * @ORM\Column(type="integer")
     * @Groups({"products_show_list", "product_show_detail"})
     * @Expose
     * @var string
     * @OA\Property(description="Phone's battery capacity, in mAh", example="3000")
     */
    private $battery;

    /**
     * @Serializer\Type("DateTime<'Y-m-d', '', ['Y-m-d', 'Y/m/d']>")
     * @ORM\Column(type="datetime")
     * @Groups({"products_show_list", "product_show_detail"})
     * @Expose
     * @var string
     * @OA\Property(description="Phone's release date", example="2018-05-27")
     */
    private $launchedAt;

    /**
     * @Serializer\Type("DateTime")
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     * @Groups({"product_show_detail"})
     * @Expose
     * @var string
     * @OA\Property(description="Phone's creation date in database", example="2021-06-19T08:37:42+00:00")
     */
    private $createdAt;

    /**
     * @Serializer\Type("integer")
     * @ORM\Column(type="integer")
     * @Groups({"products_show_list", "product_show_detail"})
     * @Expose
     * @var string
     * @OA\Property(description="Phone's price, in € (euro)", example="199")
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

    /**
     * @ORM\PrePersist()
     */
    public function prePerist()
    {
        $this->createdAt = new \DateTime();
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
