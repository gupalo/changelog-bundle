<?php

namespace Gupalo\ChangeLogBundle\Entity;

use Doctrine\DBAL\Types\Types;
use DateTime;
use DateTimeInterface;
use Gupalo\ChangeLogBundle\Repository\ChangeLogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChangeLogRepository::class)]
#[ORM\HasLifecycleCallbacks]
class ChangeLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $entity;

    #[ORM\Column(type: 'integer')]
    private int $entityId;

    #[ORM\Column(type: 'string', length: 255)]
    private string $field;

    #[ORM\Column(type: 'text')]
    private string $oldValue;

    #[ORM\Column(type: 'text')]
    private string $value;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntity(): string
    {
        return $this->entity;
    }

    public function setEntity(string $entity): self
    {
        $this->entity = $entity;

        return $this;
    }

    public function getEntityId(): int
    {
        return $this->entityId;
    }

    public function setEntityId(int $entityId): self
    {
        $this->entityId = $entityId;

        return $this;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    public function getOldValue(): string
    {
        return $this->oldValue;
    }

    public function setOldValue(string $oldValue): self
    {
        $this->oldValue = $oldValue;

        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(?string $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function initializeCreatedAt(): void
    {
        if (!isset($this->createdAt)) {
            $this->createdAt = new DateTime();
        }
    }
}
