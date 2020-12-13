<?php

namespace App\Entity\Embed;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Embeddable()
 */
class Buyer
{
    /**
     * @var int $id
     * @ORM\Column(type="integer")
     * @Groups("api")
     */
    private int $id;

    /**
     * @var string $name
     * @ORM\Column(type="string",length=20)
     * @Groups("api")
     */
    private string $name;

    /**
     * @var string $mobile
     * @ORM\Column(type="string",length=20)
     * @Groups("api")
     */
    private string $mobile;

    /**
     * @var string $avatar
     * @ORM\Column(type="string",length=255)
     * @Groups("api")
     */
    private string $avatar;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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
    public function getAvatar(): string
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar(string $avatar): void
    {
        $this->avatar = $avatar;
    }
}
