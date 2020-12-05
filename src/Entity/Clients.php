<?php

namespace App\Entity;

use App\Repository\ClientsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ClientsRepository::class)
 */
class Clients
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * 用户名
     * @ORM\Column(type="string", length=255)
     * @Groups("api")
     */
    private string $username;

    /**
     * 手机号码
     * @ORM\Column(type="string", length=20, unique=true)
     * @Groups("api")
     */
    private string $mobile;

    /**
     * 头像
     * @ORM\Column(type="string", length=255)
     * @Groups("api")
     */
    private string $avatar;

    /**
     * 性别
     * @ORM\Column(type="string",length=10)
     * @Groups("api")
     */
    private string $gender;

    /**
     * @var string $openId
     * @ORM\Column(type="string",length=100)
     * @Groups("api")
     */
    private string $openId;

    /**
     * 注册时间
     * @Gedmo\Timestampable(on="create")
     * @var \DateTime $registerAt
     * @ORM\Column(type="datetime")
     */
    private \DateTime $registerAt;

    /**
     * 更新时间
     * @Gedmo\Timestampable(on="update")
     * @var \DateTime $updateAt
     * @ORM\Column(type="datetime")
     */
    private \DateTime $updateAt;

    /**
     * 最后登录时间
     * @var \DateTime $updateAt
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private \DateTime $lastLoginAt;

    /**
     * @ORM\OneToMany(targetEntity=Coupons::class, mappedBy="client")
     */
    private $coupons;

    public function __construct()
    {
        $this->coupons = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getUsername();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return \DateTime
     */
    public function getRegisterAt(): \DateTime
    {
        return $this->registerAt;
    }

    /**
     * @param \DateTime $registerAt
     */
    public function setRegisterAt(\DateTime $registerAt): void
    {
        $this->registerAt = $registerAt;
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
     * @return \DateTime
     */
    public function getLastLoginAt(): \DateTime
    {
        return $this->lastLoginAt;
    }

    /**
     * @param \DateTime $lastLoginAt
     */
    public function setLastLoginAt(\DateTime $lastLoginAt): void
    {
        $this->lastLoginAt = $lastLoginAt;
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
            $coupon->setClient($this);
        }

        return $this;
    }

    public function removeCoupon(Coupons $coupon): self
    {
        if ($this->coupons->removeElement($coupon)) {
            // set the owning side to null (unless already changed)
            if ($coupon->getClient() === $this) {
                $coupon->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getOpenId(): string
    {
        return $this->openId;
    }

    /**
     * @param string $openId
     */
    public function setOpenId(string $openId): void
    {
        $this->openId = $openId;
    }
}
