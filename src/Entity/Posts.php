<?php

namespace App\Entity;

use App\Repository\PostsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Length;

#[ORM\Entity(repositoryClass: PostsRepository::class)]
class Posts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $posts_picture;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $posts_place;

    #[ORM\Column(type: 'text', nullable: true), Length(min: 5)]
    private $posts_describe;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostsPicture(): ?string
    {
        return $this->posts_picture;
    }

    public function setPostsPicture(string $posts_picture): self
    {
        $this->posts_picture = $posts_picture;

        return $this;
    }

    public function getPostsPlace(): ?string
    {
        return $this->posts_place;
    }

    public function setPostsPlace(?string $posts_place): self
    {

        $this->posts_place = $posts_place;

        return $this;
    }

    public function getPostsDescribe(): ?string
    {
        return $this->posts_describe;
    }

    public function setPostsDescribe(?string $posts_describe): self
    {
        $this->posts_describe = $posts_describe;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
