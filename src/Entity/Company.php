<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 */
class Company
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
     * @ORM\OneToMany(targetEntity=Stores::class, mappedBy="company")
     * @Groups("api")
     */
    private $stores;

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

    public function __construct()
    {
        $this->stores = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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
            $store->setCompany($this);
        }

        return $this;
    }

    public function removeStore(Stores $store): self
    {
        if ($this->stores->removeElement($store)) {
            // set the owning side to null (unless already changed)
            if ($store->getCompany() === $this) {
                $store->setCompany(null);
            }
        }

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

    public function __toString()
    {
        return $this->title;
    }
}
