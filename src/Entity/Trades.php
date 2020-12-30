<?php

namespace App\Entity;

use App\Repository\TradesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TradesRepository::class)
 */
class Trades
{
    const STATUS_WAIT_PAY = 'wait_pay';//待支付
    const STATUS_PAID = 'paid';//已支付
    const STATUS_FINISHED = 'finished';//已完成
    const STATUS_CANCELED = 'canceled';//已取消

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string $tid
     * @ORM\Column(type="string")
     * @Groups("api")
     */
    private string $tid;

    /**
     * @var \App\Entity\Embed\Buyer $buyer
     * @ORM\Embedded(class="App\Entity\Embed\Buyer",columnPrefix="buyer_")
     * @Groups("api")
     */
    private $buyer;

    /**
     * @var \App\Entity\Embed\TradePayment $payment
     * @ORM\Embedded(class="App\Entity\Embed\TradePayment",columnPrefix="trade_")
     * @Groups("api")
     */
    private $payment;

    /**
     * 创建时间
     * @Gedmo\Timestampable(on="create")
     * @var \DateTime $createAt
     * @ORM\Column(type="datetime")
     * @Groups("api")
     */
    private \DateTime $createAt;

    /**
     * 支付时间
     * @Gedmo\Timestampable(on="change",field="status",value={"paid"})
     * @var \DateTime $payAt
     * @ORM\Column(type="datetime",nullable=true)
     * @Groups("api")
     */
    private ?\DateTime $payAt = null;

    /**
     * 更新时间
     * @Gedmo\Timestampable()
     * @var \DateTime $updateAt
     * @ORM\Column(type="datetime")
     */
    private \DateTime $updateAt;

    /**
     * @ORM\OneToMany(targetEntity=Orders::class, mappedBy="trades")
     * @Groups("api")
     */
    private $orders;

    /**
     * @var string $status
     * @ORM\Column(type="string",length=20)
     */
    private string $status;


    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Orders[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setTrades($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getTrades() === $this) {
                $order->setTrades(null);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getTid(): string
    {
        return $this->tid;
    }

    /**
     * @param string $tid
     */
    public function setTid(string $tid): void
    {
        $this->tid = $tid;
    }

    /**
     * @return Embed\Buyer
     */
    public function getBuyer(): Embed\Buyer
    {
        return $this->buyer;
    }

    /**
     * @param Embed\Buyer $buyer
     */
    public function setBuyer(Embed\Buyer $buyer): void
    {
        $this->buyer = $buyer;
    }

    /**
     * @return Embed\TradePayment
     */
    public function getPayment(): ?Embed\TradePayment
    {
        return $this->payment;
    }

    /**
     * @param Embed\TradePayment $payment
     */
    public function setPayment(Embed\TradePayment $payment): void
    {
        $this->payment = $payment;
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
    public function getPayAt(): ?\DateTime
    {
        return $this->payAt;
    }

    /**
     * @param \DateTime $payAt
     */
    public function setPayAt(\DateTime $payAt): void
    {
        $this->payAt = $payAt;
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
     * @return string
     * @Groups("api")
     */
    public function getStatusLabel()
    {
        $map = [
            Trades::STATUS_WAIT_PAY => '待支付',
            Trades::STATUS_CANCELED => '已取消',
            Trades::STATUS_FINISHED => '已完成',
            Trades::STATUS_PAID => '已支付',
        ];
        return $map[$this->status];
    }

    /**
     * @return string
     * @Groups("api")
     */
    public function getCreateDate()
    {
        return $this->createAt->format('Y/m/d H:i');
    }

    /**
     * @return array
     * @Groups("api")
     */
    public function getAvailableOperations()
    {
        $status = $this->getStatus();
        if ($status == self::STATUS_WAIT_PAY) {
            return [
                ['action' => 'pay', 'label' => '支付'],
            ];
        }else if ($status == self::STATUS_PAID) {
            return [
                ['action' => 'useCoupon', 'label' => '用券'],
            ];
        }
        return [
            ['action' => 'detail', 'label' => '详情'],
        ];
    }
}
