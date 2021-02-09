<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Person::class, inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $person;

    /**
     * @ORM\ManyToOne(targetEntity=Favorite::class, inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $favorite;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $sentAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $date_created_sms;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $date_updated_sms;

    /**
     * Permet de générer la date de création
     * @ORM\PrePersist
     */
    public function prePersist(){
        if (empty($this->createdAt)){
            $this->createdAt = new \DateTime();
        }
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getFavorite(): ?Favorite
    {
        return $this->favorite;
    }

    public function setFavorite(?Favorite $favorite): self
    {
        $this->favorite = $favorite;

        return $this;
    }

    public function getSentAt(): ?\DateTimeInterface
    {
        return $this->sentAt;
    }

    public function setSentAt(?\DateTimeInterface $sentAt): self
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    public function getState(): ?bool
    {
        return $this->state;
    }

    public function setState(?bool $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getSid(): ?string
    {
        return $this->sid;
    }

    public function setSid(?string $sid): self
    {
        $this->sid = $sid;

        return $this;
    }

    public function getDateCreatedSms(): ?string
    {
        return $this->date_created_sms;
    }

    public function setDateCreatedSms(?string $date_created_sms): self
    {
        $this->date_created_sms = $date_created_sms;

        return $this;
    }

    public function getDateUpdatedSms(): ?string
    {
        return $this->date_updated_sms;
    }

    public function setDateUpdatedSms(?string $date_updated_sms): self
    {
        $this->date_updated_sms = $date_updated_sms;

        return $this;
    }
}
