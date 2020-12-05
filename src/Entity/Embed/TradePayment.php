<?php

namespace App\Entity\Embed;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class TradePayment
{
    /**
     * @var float $price
     * @ORM\Column(type="float")
     */
    private float $price;

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
}
