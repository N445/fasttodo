<?php

namespace App\Entity;

use App\Repository\TodolistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TodolistRepository::class)
 * @UniqueEntity("hash")
 */
class Todolist
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hash;
    
    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $name;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    
    /**
     * @ORM\OneToMany(targetEntity=Item::class, mappedBy="todolist",cascade={"persist","remove"})
     */
    private $items;
    
    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->setCreatedAt(new \DateTime("NOW"));
    }
    
    public function getId(): ?int
    {
        return $this->id;
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
    
    public function getName(): ?string
    {
        return $this->name;
    }
    
    public function setName(string $name): self
    {
        $this->name = $name;
        
        return $this;
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
    
    /**
     * @return Collection|Item[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }
    
    public function addItem(Item $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setTodolist($this);
        }
        
        return $this;
    }
    
    public function removeItem(Item $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getTodolist() === $this) {
                $item->setTodolist(null);
            }
        }
        
        return $this;
    }
}
