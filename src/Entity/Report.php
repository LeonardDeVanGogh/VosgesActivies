<?php

namespace App\Entity;

use App\Repository\ReportRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReportRepository::class)
 */
class Report
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=comment::class, inversedBy="reports")
     * @ORM\JoinColumn(nullable=false)
     */
    private $comment_id;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="reports")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity=reportReason::class, inversedBy="reports")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reason_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $moderated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentId(): ?comment
    {
        return $this->comment_id;
    }

    public function setCommentId(?comment $comment_id): self
    {
        $this->comment_id = $comment_id;

        return $this;
    }

    public function getUserId(): ?user
    {
        return $this->user_id;
    }

    public function setUserId(?user $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getReasonId(): ?reportReason
    {
        return $this->reason_id;
    }

    public function setReasonId(?reportReason $reason_id): self
    {
        $this->reason_id = $reason_id;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getModeratedAt(): ?\DateTimeInterface
    {
        return $this->moderated_at;
    }

    public function setModeratedAt(?\DateTimeInterface $moderated_at): self
    {
        $this->moderated_at = $moderated_at;

        return $this;
    }
}
