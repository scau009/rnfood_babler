<?php

namespace App\Entity;

use App\Repository\StoresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=StoresRepository::class)
 */
class Stores
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("api")
     */
    private $id;

    /**
     * 店铺名称
     * @var string $title
     * @ORM\Column(type="string",length=255)
     * @Groups("api")
     */
    private string $title;

    /**
     * 小图标
     * @var string $logo
     * @ORM\Column(type="string",length=255)
     * @Groups("api")
     */
    private string $logo;

    /**
     * 店铺宣传图
     * @var array $banners
     * @ORM\Column(type="array")
     * @Groups("api")
     */
    private array $banners;

    /**
     * 店铺评分
     * @var float $score
     * @ORM\Column(type="float")
     * @Groups("api")
     */
    private float $score;

    /**
     * 用户like
     * @var float $likes
     * @ORM\Column(type="float")
     * @Groups("api")
     */
    private float $likes;

    /**
     * @var string $mobile
     * @ORM\Column(type="string",length=20)
     * @Groups("api")
     */
    private string $mobile;

    /**
     * @var string $dayBegin
     * @ORM\Column(type="string",length=10)
     * @Groups("api")
     */
    private string $dayBegin;

    /**
     * @var string $dayEnd
     * @ORM\Column(type="string",length=10)
     * @Groups("api")
     */
    private string $dayEnd;

    /**
     * @var string $timeBegin
     * @ORM\Column(type="string",length=10)
     * @Groups("api")
     */
    private string $timeBegin;

    /**
     * @var string $timeEnd
     * @ORM\Column(type="string",length=10)
     * @Groups("api")
     */
    private string $timeEnd;

    /**
     * @var string $status
     * @ORM\Column(type="string")
     * @Groups("api")
     */
    private string $status;

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
     * @var Products[] $products
     * @ORM\ManyToMany(targetEntity=Products::class, mappedBy="stores")
     */
    private $products;

    /**
     * @var Company $company
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="stores")
     * @Groups("api")
     */
    private $company;

    /**
     * @var string $province
     * @ORM\Column(type="string",length=20)
     * @Groups("api")
     */
    private string $province = '';

    /**
     * @var string $city
     * @ORM\Column(type="string",length=20)
     * @Groups("api")
     */
    private string $city = '';

    /**
     * @var string $area
     * @ORM\Column(type="string",length=20)
     * @Groups("api")
     */
    private string $area = '';

    /**
     * @var string $route
     * @ORM\Column(type="string",length=200)
     * @Groups("api")
     */
    private string $route = '';

    /**
     * @var float $locationX
     * @ORM\Column(type="float")
     * @Groups("api")
     */
    private float $locationX = 0;

    /**
     * @var float $locationY
     * @ORM\Column(type="float")
     * @Groups("api")
     */
    private float $locationY = 0;

    /**
     * @ORM\ManyToMany(targetEntity=Coupons::class, mappedBy="stores")
     */
    private $coupons;

    public function __toString()
    {
        return $this->title;
    }

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->coupons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return string
     */
    public function getLogo(): string
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     */
    public function setLogo(string $logo): void
    {
        $this->logo = $logo;
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
     * @return float
     */
    public function getScore(): float
    {
        return $this->score;
    }

    /**
     * @param float $score
     */
    public function setScore(float $score): void
    {
        $this->score = $score;
    }

    /**
     * @return float
     */
    public function getLikes(): float
    {
        return $this->likes;
    }

    /**
     * @param float $likes
     */
    public function setLikes(float $likes): void
    {
        $this->likes = $likes;
    }

    /**
     * @return string
     */
    public function getMobile(): string
    {
        return $this->mobile;
    }

    /**
     * @param string $mobile
     */
    public function setMobile(string $mobile): void
    {
        $this->mobile = $mobile;
    }

    /**
     * @return string
     */
    public function getDayBegin(): string
    {
        return $this->dayBegin;
    }

    /**
     * @param string $dayBegin
     */
    public function setDayBegin(string $dayBegin): void
    {
        $this->dayBegin = $dayBegin;
    }

    /**
     * @return string
     */
    public function getDayEnd(): string
    {
        return $this->dayEnd;
    }

    /**
     * @param string $dayEnd
     */
    public function setDayEnd(string $dayEnd): void
    {
        $this->dayEnd = $dayEnd;
    }

    /**
     * @return string
     */
    public function getTimeBegin(): string
    {
        return $this->timeBegin;
    }

    /**
     * @param string $timeBegin
     */
    public function setTimeBegin(string $timeBegin): void
    {
        $this->timeBegin = $timeBegin;
    }

    /**
     * @return string
     */
    public function getTimeEnd(): string
    {
        return $this->timeEnd;
    }

    /**
     * @param string $timeEnd
     */
    public function setTimeEnd(string $timeEnd): void
    {
        $this->timeEnd = $timeEnd;
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
     * @return Collection|Products[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Products $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addStore($this);
        }

        return $this;
    }

    public function removeProduct(Products $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removeStore($this);
        }

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
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
    public function getProvince(): string
    {
        return $this->province;
    }

    /**
     * @param string $province
     */
    public function setProvince(string $province): void
    {
        $this->province = $province;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getArea(): string
    {
        return $this->area;
    }

    /**
     * @param string $area
     */
    public function setArea(string $area): void
    {
        $this->area = $area;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @param string $route
     */
    public function setRoute(string $route): void
    {
        $this->route = $route;
    }

    /**
     * @return float
     */
    public function getLocationX(): float
    {
        return $this->locationX;
    }

    /**
     * @param float $locationX
     */
    public function setLocationX(float $locationX): void
    {
        $this->locationX = $locationX;
    }

    /**
     * @return float
     */
    public function getLocationY(): float
    {
        return $this->locationY;
    }

    /**
     * @param float $locationY
     */
    public function setLocationY(float $locationY): void
    {
        $this->locationY = $locationY;
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
            $coupon->addStore($this);
        }

        return $this;
    }

    public function removeCoupon(Coupons $coupon): self
    {
        if ($this->coupons->removeElement($coupon)) {
            $coupon->removeStore($this);
        }

        return $this;
    }
}
