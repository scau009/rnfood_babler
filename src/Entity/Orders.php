<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @Groups("api")
     */
    private string $oid;

    /**
     * @var \App\Entity\Embed\Products $prodcut
     * @ORM\Embedded(class="App\Entity\Embed\Products",columnPrefix="product_")
     * @Groups("api")
     */
    private $product;

    /**
     * @var int $num
     * @ORM\Column(type="integer")
     * @Groups("api")
     */
    private int $num;

    /**
     * @var \App\Entity\Embed\OrderPayment $payment
     * @ORM\Embedded(class="App\Entity\Embed\OrderPayment",columnPrefix="order_")
     * @Groups("api")
     */
    private $payment;

    /**
     * @ORM\ManyToOne(targetEntity=Trades::class, inversedBy="orders")
     */
    private $trades;

    /**
     * @ORM\OneToMany(targetEntity=Coupons::class, mappedBy="orders")
     * @Groups("api")
     */
    private $coupons;

    public function __construct()
    {
        $this->coupons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
    public function getPayment(): ?Embed\OrderPayment
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

    /**
     * @return Collection|Coupons[]
     */
    public function getCoupons(): Collection
    {
        return $this->coupons;
    }

    public function addCoupon(Coupons $coupon): self
    {
        if (!$this->coupons->contains($coupon)) {
            $this->coupons[] = $coupon;
            $coupon->setOrders($this);
        }

        return $this;
    }

    public function removeCoupon(Coupons $coupon): self
    {
        if ($this->coupons->removeElement($coupon)) {
            // set the owning side to null (unless already changed)
            if ($coupon->getOrders() === $this) {
                $coupon->setOrders(null);
            }
        }

        return $this;
    }
}
