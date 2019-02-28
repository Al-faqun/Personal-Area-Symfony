<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ManagerRepository")
 */
class Manager
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $tel;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cargo", mappedBy="manager")
     */
    private $cargoes;

    public function __construct()
    {
        $this->cargoes = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $Surname): self
    {
        $this->surname = $Surname;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }
    
    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }
    
    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * @return Collection|Cargo[]
     */
    public function getCargoes(): Collection
    {
        return $this->cargoes;
    }
    
    public function addCargo(Cargo $cargo): self
    {
        if (!$this->cargoes->contains($cargo)) {
            $this->cargoes[] = $cargo;
            $cargo->setManager($this);
        }
        
        return $this;
    }
    
    public function removeCargo(Cargo $cargo): self
    {
        if ($this->cargoes->contains($cargo)) {
            $this->cargoes->removeElement($cargo);
            // set the owning side to null (unless already changed)
            if ($cargo->getManager() === $this) {
                $cargo->setManager(null);
            }
        }
        
        return $this;
    }
}
