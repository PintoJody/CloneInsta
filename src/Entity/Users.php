<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $users_name;

    #[ORM\Column(type: 'string', length: 255)]
    private $users_pseudo;

    #[ORM\Column(type: 'date', nullable: true)]
    private $users_birth;

    #[ORM\Column(type: 'text', nullable: true)]
    private $users_bio;

    #[ORM\Column(type: 'date')]
    private $users_mail;

    #[ORM\Column(type: 'string', length: 255)]
    private $users_password;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private $users_phone;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsersName(): ?string
    {
        return $this->users_name;
    }

    public function setUsersName(string $users_name): self
    {
        $this->users_name = $users_name;

        return $this;
    }

    public function getUsersPseudo(): ?string
    {
        return $this->users_pseudo;
    }

    public function setUsersPseudo(string $users_pseudo): self
    {
        $this->users_pseudo = $users_pseudo;

        return $this;
    }

    public function getUsersBirth(): ?\DateTimeInterface
    {
        return $this->users_birth;
    }

    public function setUsersBirth(?\DateTimeInterface $users_birth): self
    {
        $this->users_birth = $users_birth;

        return $this;
    }

    public function getUsersBio(): ?string
    {
        return $this->users_bio;
    }

    public function setUsersBio(?string $users_bio): self
    {
        $this->users_bio = $users_bio;

        return $this;
    }

    public function getUsersMail(): ?\DateTimeInterface
    {
        return $this->users_mail;
    }

    public function setUsersMail(\DateTimeInterface $users_mail): self
    {
        $this->users_mail = $users_mail;

        return $this;
    }

    public function getUsersPassword(): ?string
    {
        return $this->users_password;
    }

    public function setUsersPassword(string $users_password): self
    {
        $this->users_password = $users_password;

        return $this;
    }

    public function getUsersPhone(): ?string
    {
        return $this->users_phone;
    }

    public function setUsersPhone(?string $users_phone): self
    {
        $this->users_phone = $users_phone;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
