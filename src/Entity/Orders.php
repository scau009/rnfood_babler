<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrdersRepository::class)
 */
class Orders
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string $oid
     * @ORM\Column(type="string")
     */
    private string $oid;

    /**
     * @var \App\Entity\Embed\Products $prodcut
     * @ORM\Embedded(class="App\Entity\Embed\Products",columnPrefix="product_")
     */
    private $product;

    /**
     * @var int $num
     * @ORM\Column(type="integer")
     */
    private int $num;

    /**
     * @ORM\ManyToOne(targetEntity=Stores::class, inversedBy="orders")
     */
    private $store;

    /**
     * @var \App\Entity\Embed\OrderPayment $payment
     * @ORM\Embedded(class="App\Entity\Embed\OrderPayment",columnPrefix="order_")
     */
    private $payment;

    /**
     * @ORM\ManyToOne(targetEntity=Trades::class, inversedBy="orders")
     */
    private $trades;

    /**
     * @var string $status
     * @ORM\Column(type="string",length=20)
     */
    private string $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStore(): ?Stores
    {
        return $this->store;
    }

    public function setStore(?Stores $store): self
    {
        $this->store = $store;

        return $this;
    }

    public function getTrades(): ?Trades
    {
        return $this->trades;
    }

    public function setTrades(?Trades $trades): self
    {
        $this->trades = $trades;

        return $this;
    }

    /**
     * @return string
     */
    public function getOid(): string
    {
        return $this->oid;
    }

    /**
     * @param string $oid
     */
    public function setOid(string $oid): void
    {
        $this->oid = $oid;
    }

    /**
     * @return Embed\Products
     */
    public function getProduct(): Embed\Products
    {
        return $this->product;
    }

    /**
     * @param Embed\Products $product
     */
    public function setProduct(Embed\Products $product): void
    {
        $this->product = $product;
    }

    /**
     * @return Embed\OrderPayment
     */
    public function getPayment(): Embed\OrderPayment
    {
        return $this->payment;
    }

    /**
     * @param Embed\OrderPayment $payment
     */
    public function setPayment(Embed\OrderPayment $payment): void
    {
        $this->payment = $payment;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getNum(): int
    {
        return $this->num;
    }

    /**
     * @param int $num
     */
    public function setNum(int $num): void
    {
        $this->num = $num;
    }
}
