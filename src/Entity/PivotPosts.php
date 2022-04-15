<?php

namespace App\Entity;

use App\Repository\PivotPostsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PivotPostsRepository::class)]
class PivotPosts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $posts_id;

    #[ORM\Column(type: 'integer')]
    private $users_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostsId(): ?int
    {
        return $this->posts_id;
    }

    public function setPostsId(int $posts_id): self
    {
        $this->posts_id = $posts_id;

        return $this;
    }

    public function getUsersId(): ?int
    {
        return $this->users_id;
    }

    public function setUsersId(int $users_id): self
    {
        $this->users_id = $users_id;

        return $this;
    }
}
