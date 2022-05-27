<?php

namespace App\Entity;

use App\Repository\PostsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'post', targetEntity: Comment::class, orphanRemoval: true)]
    private $comments;

    #[ORM\OneToMany(mappedBy: 'post', targetEntity: CommentPost::class)]
    private $commentPosts;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->commentPosts = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->posts_describe;
    }

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

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommentPost>
     */
    public function getCommentPosts(): Collection
    {
        return $this->commentPosts;
    }

    public function addCommentPost(CommentPost $commentPost): self
    {
        if (!$this->commentPosts->contains($commentPost)) {
            $this->commentPosts[] = $commentPost;
            $commentPost->setPost($this);
        }

        return $this;
    }

    public function removeCommentPost(CommentPost $commentPost): self
    {
        if ($this->commentPosts->removeElement($commentPost)) {
            // set the owning side to null (unless already changed)
            if ($commentPost->getPost() === $this) {
                $commentPost->setPost(null);
            }
        }

        return $this;
    }
}
