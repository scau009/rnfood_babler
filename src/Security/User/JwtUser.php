<?php


namespace App\Security\User;


use App\Entity\Clients;
use Symfony\Component\Security\Core\User\UserInterface;

class JwtUser implements UserInterface
{

    /**
     * @var string
     */
    private string $jwt = '';
    /**
     * @var string
     */
    private string $id = '';
    /**
     * @var string
     */
    private string $userName = '';

    /**
     * @var array
     */
    private array $roles = [];

    /**
     * @var string
     */
    private string $openId = '';

    private ?Clients $entity;

    /**
     * @return string
     */
    public function getJwt(): string
    {
        return $this->jwt;
    }

    /**
     * @param string $jwt
     */
    public function setJwt(string $jwt): void
    {
        $this->jwt = $jwt;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
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

    /**
     * @return Clients
     */
    public function getEntity(): ?Clients
    {
        return $this->entity;
    }

    /**
     * @param Clients $entity
     */
    public function setEntity(Clients $entity): void
    {
        $this->entity = $entity;
    }



    public function getRoles()
    {
        return $this->roles ?: [];
    }

    public function getPassword()
    {
    }

    public function getSalt()
    {
    }

    public function getUsername()
    {
        return strval($this->userName);
    }

    public function eraseCredentials()
    {

    }

}