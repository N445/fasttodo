<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ItemRepository::class)
 */
class Item
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
    private $title;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $isChecked;
    
    /**
     * @ORM\ManyToOne(targetEntity=Todolist::class, inversedBy="items")
     */
    private $todolist;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordre;
    
    public function __construct(string $name)
    {
        $this->setIsChecked(false);
        $this->setTitle($name);
        $this->setOrdre(0);
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getTitle(): ?string
    {
        return $this->title;
    }
    
    public function setTitle(string $title): self
    {
        $this->title = $title;
        
        return $this;
    }
    
    public function getIsChecked(): ?bool
    {
        return $this->isChecked;
    }
    
    public function setIsChecked(bool $isChecked): self
    {
        $this->isChecked = $isChecked;
        
        return $this;
    }
    
    public function getTodolist(): ?Todolist
    {
        return $this->todolist;
    }
    
    public function setTodolist(?Todolist $todolist): self
    {
        $this->todolist = $todolist;
        
        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }
}
