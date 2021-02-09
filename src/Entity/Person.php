<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PersonRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *      fields={"phoneMain"},
 *      message="Ce numéro de téléphone a été déjà enregistré"
 * )
 */
class Person
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
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $phoneMain;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $phoneSecond;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Group::class, inversedBy="people")
     */
    private $groupe;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="person")
     */
    private $messages;

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
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $valid;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhoneMain(): ?string
    {
        return $this->phoneMain;
    }

    public function setPhoneMain(string $phoneMain): self
    {
        $this->phoneMain = $phoneMain;

        return $this;
    }

    public function getPhoneSecond(): ?string
    {
        return $this->phoneSecond;
    }

    public function setPhoneSecond(?string $phoneSecond): self
    {
        $this->phoneSecond = $phoneSecond;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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

    public function getGroupe(): ?Group
    {
        return $this->groupe;
    }

    public function setGroupe(?Group $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setPerson($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getPerson() === $this) {
                $message->setPerson(null);
            }
        }

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

    public function getValid(): ?bool
    {
        return $this->valid;
    }

    public function setValid(?bool $valid): self
    {
        $this->valid = $valid;

        return $this;
    }
}
