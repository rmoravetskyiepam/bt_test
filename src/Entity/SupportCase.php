<?php

namespace App\Entity;

use App\Entity\Enum\StatusType;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SupportCaseRepository;

#[ORM\Entity(repositoryClass: SupportCaseRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'support_case')]
class SupportCase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    private ?int $id = null;

    #[ORM\Column(name: 'summary', type: 'string', nullable: false)]
    private ?string $summary = null;

    #[ORM\Column(name: 'description', type: 'text', nullable: false)]
    private ?string $description = null;

    #[ORM\Column(name: 'image_url', type: 'string', nullable: true)]
    private ?string $imageUrl = null;

    #[ORM\Column(name: 'status', type: 'string', nullable: false, enumType: StatusType::class)]
    private StatusType $status = StatusType::OPEN;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'creator_id', referencedColumnName: 'id')]
    private User|null $creator = null;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: 'modified_at', type: 'datetime', nullable: true)]
    private ?\DateTime $modifiedAt = null;

    #[ORM\PrePersist]
    public function setValuesBeforeEntityCreate(): void
    {
        $this->createdAt = new \DateTime();
        $this->modifiedAt = new \DateTime();
    }

    #[ORM\PreUpdate]
    public function setValuesBeforeEntityUpdate(): void
    {
        $this->modifiedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    public function getStatus(): StatusType
    {
        return $this->status;
    }

    public function setStatus(string|StatusType $status): self
    {
        if (is_string($status)) {
            foreach (StatusType::cases() as $case) {
                if ($case->value === $status) {
                    $this->status = $case;
                    return $this;
                }
            }

            throw new \InvalidArgumentException('Status doesn\'t exist in enum.');
        }

        $this->status = $status;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;
        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getModifiedAt(): ?\DateTime
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(?\DateTime $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }

}
