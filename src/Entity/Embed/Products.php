<?php

namespace App\Entity\Embed;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Embeddable()
 */
class Products
{
    /**
     * @ORM\Column(type="integer")
     * @Groups("api")
     */
    private $id;

    /**
     * @var string $headImage
     * @ORM\Column(type="string",length=255)
     * @Groups("api")
     */
    private string $headImage = '';

    /**
     * @var string $title
     * @ORM\Column(type="string",length=255)
     * @Groups("api")
     */
    private string $title;

    /**
     * @var float $price
     * @ORM\Column(type="float")
     * @Groups("api")
     */
    private float $price;

    /**
     * @var float $priceWas
     * @ORM\Column(type="integer")
     * @Groups("api")
     */
    private float $priceWas;

    /**
     * @ORM\Column(type="text")
     * @Groups("api")
     */
    private $description;

    /**
     * @ORM\Column(type="array")
     * @Groups("api")
     * @var array $stores
     */
    private array $storeIds = [];

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getPriceWas(): float
    {
        return $this->priceWas;
    }

    /**
     * @param float $priceWas
     */
    public function setPriceWas(float $priceWas): void
    {
        $this->priceWas = $priceWas;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return array
     */
    public function getStoreIds(): array
    {
        return $this->storeIds;
    }

    /**
     * @param array $storeIds
     */
    public function setStoreIds(array $storeIds): void
    {
        $this->storeIds = $storeIds;
    }

    /**
     * @return string
     */
    public function getHeadImage(): string
    {
        return $this->headImage;
    }

    /**
     * @param string $headImage
     */
    public function setHeadImage(string $headImage): void
    {
        $this->headImage = $headImage;
    }
}
