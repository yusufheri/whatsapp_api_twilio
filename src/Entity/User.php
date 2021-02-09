<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *      fields={"email"},
 *      message="Un autre utilisateur s'est déjà inscris avec cette adresse email, merci de la modifier"
 * )
 */
class User implements UserInterface 
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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hash;

    /**
     * @Assert\EqualTo(propertyPath="hash", message="Vous n'avez pas correctement confirmé votre mot de passe !")
     */
    public $passwordConfirm;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @ORM\ManyToMany(targetEntity=Role::class, inversedBy="users")
     */
    private $userRoles;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fullname;

    public function __construct()
    {
        $this->userRoles = new ArrayCollection();
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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return Collection|Role[]
     */
    public function getUserRoles(): Collection
    {
        return $this->userRoles;
    }

    public function addUserRole(Role $userRole): self
    {
        if (!$this->userRoles->contains($userRole)) {
            $this->userRoles[] = $userRole;
        }

        return $this;
    }

    public function removeUserRole(Role $userRole): self
    {
        $this->userRoles->removeElement($userRole);

        return $this;
    }

    public function getRoles()
    {
        $roles = $this->userRoles->map(function($role){
            /** @var Role $role */
              return $role->getName();
        })->toArray();

        $roles [] = 'ROLE_USER';
        
        return $roles;
    }

    public function getPassword() {
        return $this->hash;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function getSalt(){}

    public function eraseCredentials(){}

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }


    /**
     * Get the value of passwordConfirm
     */ 
    public function getPasswordConfirm()
    {
        return $this->passwordConfirm;
    }

    /**
     * Set the value of passwordConfirm
     *
     * @return  self
     */ 
    public function setPasswordConfirm($passwordConfirm)
    {
        $this->passwordConfirm = $passwordConfirm;

        return $this;
    }
}
