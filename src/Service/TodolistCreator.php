<?php


namespace App\Service;


use App\Entity\Todolist;
use App\Repository\TodolistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

class TodolistCreator
{
    /**
     * @var TodolistRepository
     */
    private $todolistRepository;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    
    /**
     * TodolistCreator constructor.
     * @param TodolistRepository $todolistRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(
        TodolistRepository $todolistRepository,
        EntityManagerInterface $em
    )
    {
        $this->todolistRepository = $todolistRepository;
        $this->em = $em;
    }
    
    /**
     * @return Todolist
     * @throws NonUniqueResultException
     */
    public function createTodolist()
    {
        do {
            $hash = uniqid();
        } while ($this->todolistRepository->getByHash($hash));
        
        $todolist = (new Todolist())->setHash($hash);
        $this->em->persist($todolist);
        $this->em->flush();
        return $todolist;
    }
}