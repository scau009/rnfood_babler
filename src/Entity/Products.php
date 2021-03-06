<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductsRepository::class)
 */
class Products
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("api")
     */
    private $id;

    /**
     * @var string $title
     * @ORM\Column(type="string",length=255)
     * @Groups("api")
     */
    private string $title;

    /**
     * @var string $headImage
     * @ORM\Column(type="string",length=255)
     * @Groups("api")
     */
    private string $headImage = '';

    /**
     * @var array $banners
     * @ORM\Column(type="array")
     * @Groups("api")
     */
    private array $banners = [];

    /**
     * @var int $likes
     * @ORM\Column(type="integer")
     * @Groups("api")
     */
    private int $likes;

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
     * @var int $quantity
     * @ORM\Column(type="integer")
     * @Groups("api")
     */
    private int $quantity;

    /**
     * @var int $soldCount
     * @ORM\Column(type="integer")
     * @Groups("api")
     */
    private int $soldCount;

    /**
     * @ORM\ManyToMany(targetEntity=ProductTags::class, inversedBy="products")
     * @Groups("api")
     */
    private $tags = [];

    /**
     * @ORM\Column(type="datetime")
     * @Groups("api")
     */
    private $endTime;

    /**
     * @ORM\Column(type="text")
     * @Groups("api")
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Stores::class, inversedBy="products")
     * @Groups("api")
     */
    private $stores;

    /**
     * 创建时间
     * @Gedmo\Timestampable(on="create")
     * @var \DateTime $createAt
     * @ORM\Column(type="datetime")
     * @Groups("api")
     */
    private \DateTime $createAt;

    /**
     * 更新时间
     * @Gedmo\Timestampable(on="update")
     * @var \DateTime $updateAt
     * @ORM\Column(type="datetime")
     * @Groups("api")
     */
    private \DateTime $updateAt;

    /**
     * 状态 (onsale=在售，instock=在库中)
     * @var string $status
     * @ORM\Column(type="string")
     * @Groups("api")
     */
    private string $status;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->stores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|ProductTags[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function getTagIds()
    {
        /** @var ProductTags $tag */
        foreach ($this->tags as $tag) {
            yield $tag->getId();
        }
    }

    public function addTag(ProductTags $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(ProductTags $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Stores[]
     */
    public function getStores(): Collection
    {
        return $this->stores;
    }

    public function getStoreIds()
    {
        /** @var Stores $store */
        foreach ($this->stores as $store) {
            yield $store->getId();
        }
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
     * @return array
     */
    public function getBanners(): array
    {
        return $this->banners;
    }

    /**
     * @param array $banners
     */
    public function setBanners(array $banners): void
    {
        $this->banners = $banners;
    }

    /**
     * @return int
     */
    public function getLikes(): int
    {
        return $this->likes;
    }

    /**
     * @param int $likes
     */
    public function setLikes(int $likes): void
    {
        $this->likes = $likes;
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
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getSoldCount(): int
    {
        return $this->soldCount;
    }

    /**
     * @param int $soldCount
     */
    public function setSoldCount(int $soldCount): void
    {
        $this->soldCount = $soldCount;
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
     * @return \DateTime
     */
    public function getCreateAt(): \DateTime
    {
        return $this->createAt;
    }

    /**
     * @param \DateTime $createAt
     */
    public function setCreateAt(\DateTime $createAt): void
    {
        $this->createAt = $createAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdateAt(): \DateTime
    {
        return $this->updateAt;
    }

    /**
     * @param \DateTime $updateAt
     */
    public function setUpdateAt(\DateTime $updateAt): void
    {
        $this->updateAt = $updateAt;
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

    /**
     * @return string
     * @Groups("api")
     */
    public function getNotice()
    {
        $storeNames = join('，', $this->stores->toArray());
        return
            "<p style='font-size: 14px;color: #656d77'>1. 使用时间：即日起至2021年1 月31日</p>".
            "<p style='font-size: 14px;color: #656d77'>2. 适用门店：{$storeNames}</p>".
            "<p style='font-size: 14px;color: #656d77'>3. 无需预约，消费高峰期可能需要排队等位</p>".
            "<p style='font-size: 14px;color: #656d77'>4. 每桌每次限用一张，满 200 元可用，不可叠加</p>".
            "<p style='font-size: 14px;color: #656d77'>5. 酒水除外，全场通用</p>".
            "<p style='font-size: 14px;color: #656d77'>6. 本券不支持拼桌，拆桌买单</p>".
            "<p style='font-size: 14px;color: #656d77'>7. 本券不兑换，不找零，不可与其他优惠共享</p>".
            "<p style='font-size: 14px;color: #656d77'>8. 仅限堂食，不提供餐前外带，餐毕未吃完可以打包，打包费以商家为准</p>".
            "<p style='font-size: 14px;color: #656d77'>9. 发票、酒水饮料、停车费用等问题请详细咨询商家。</p>".
            "<p style='font-size: 14px;color: #656d77'>10. 本券为限时抢购商品，一经销售不支持退款，请谨慎抢购！</p>".
            "<p style='font-size: 14px;color: #656d77'>11. 使用方式：结算时出示给商家即可</p>"
            ;
    }
}
