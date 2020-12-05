<?php

namespace App\Entity\Embed;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Products
{
    /**
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string $title
     * @ORM\Column(type="string",length=255)
     */
    private string $title;

    /**
     * @var float $price
     * @ORM\Column(type="float")
     */
    private float $price;

    /**
     * @var float $priceWas
     * @ORM\Column(type="integer")
     */
    private float $priceWas;

    /**
     * @ORM\Column(type="text")
     */
    private $description;


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
}
