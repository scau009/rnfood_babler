<?php

namespace App\Entity;

use App\Repository\CouponsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CouponsRepository::class)
 */
class Coupons
{
    const STATUS_WAIT_USE = 'wait_use';//待使用
    const STATUS_USED = 'used';//已使用
    const STATUS_EXPIRED = 'expired';//已过期

    const TYPE_BUY = '购买';
    const TYPE_GIF = '转赠';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * 优惠券码
     * @var string $couponNo
     * @ORM\Column(type="string")
     */
    private string $couponNo;

    /**
     * 获得方式（buy=购买，gift=转赠）
     * @var string $type
     * @ORM\Column(type="string")
     */
    private string $type;

    /**
     * 优惠券状态
     * @var string $status
     * @ORM\Column(type="string")
     */
    private string $status;

    /**
     * @ORM\ManyToOne(targetEntity=Clients::class, inversedBy="coupons")
     */
    private $client;

    /**
     * @var \App\Entity\Embed\Products $prodcut
     * @ORM\Embedded(class="App\Entity\Embed\Products",columnPrefix="product_")
     */
    private $product;

    /**
     * @var int $productId
     */
    private $productId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expireAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $beginAt;

    /**
     * @ORM\ManyToMany(targetEntity=Stores::class, inversedBy="coupons")
     */
    private $stores;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $qrCode;

    /**
     * @ORM\ManyToOne(targetEntity=Orders::class, inversedBy="coupons")
     */
    private $orders;

    public function __construct()
    {
        $this->stores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Clients
    {
        return $this->client;
    }

    public function setClient(?Clients $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getExpireAt(): ?\DateTimeInterface
    {
        return $this->expireAt;
    }

    public function setExpireAt(\DateTimeInterface $expireAt): self
    {
        $this->expireAt = $expireAt;

        return $this;
    }

    public function getBeginAt(): ?\DateTimeInterface
    {
        return $this->beginAt;
    }

    public function setBeginAt(\DateTimeInterface $beginAt): self
    {
        $this->beginAt = $beginAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getCouponNo(): string
    {
        return $this->couponNo;
    }

    /**
     * @param string $couponNo
     */
    public function setCouponNo(string $couponNo): void
    {
        $this->couponNo = $couponNo;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
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
     * @return Embed\Products
     */
    public function getProduct(): ?Embed\Products
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
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId ? $this->productId : ($this->product ? $this->product->getId() : 0);
    }

    /**
     * @param int $productId
     */
    public function setProductId(int $productId): void
    {
        $this->productId = $productId;
    }

    /**
     * @return Collection|Stores[]
     */
    public function getStores(): Collection
    {
        return $this->stores;
    }

    public function addStore(Stores $store): self
    {
        if (!$this->stores->contains($store)) {
            $this->stores[] = $store;
        }

        return $this;
    }

    public function removeStore(Stores $store): self
    {
        $this->stores->removeElement($store);

        return $this;
    }

    public function getQrCode(): ?string
    {
        return $this->qrCode;
    }

    public function setQrCode(string $qrCode): self
    {
        $this->qrCode = $qrCode;

        return $this;
    }

    public function getOrders(): ?Orders
    {
        return $this->orders;
    }

    public function setOrders(?Orders $orders): self
    {
        $this->orders = $orders;

        return $this;
    }
}
