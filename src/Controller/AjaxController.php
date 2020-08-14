<?php

namespace App\Controller;

use App\Entity\Item;
use App\Repository\ItemRepository;
use App\Repository\TodolistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ajax")
 */
class AjaxController extends AbstractController
{
    /**
     * @var TodolistRepository
     */
    private $todolistRepository;
    /**
     * @var ItemRepository
     */
    private $itemRepository;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    
    /**
     * AjaxController constructor.
     * @param TodolistRepository $todolistRepository
     * @param ItemRepository $itemRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(
        TodolistRepository $todolistRepository,
        ItemRepository $itemRepository,
        EntityManagerInterface $em
    )
    {
        $this->todolistRepository = $todolistRepository;
        $this->itemRepository = $itemRepository;
        $this->em = $em;
    }
    
    /**
     * @Route("/update-name/{hash}", name="UPDATE_NAME",options={"expose"=true})
     */
    public function updateName(Request $request, string $hash)
    {
        if (!$todolist = $this->todolistRepository->getByHash($hash)) {
            return $this->json([
                'success' => false,
                'reason' => 'no todolist',
            ]);
        }
        if (!$submittedToken = $request->query->get('token')) {
            return $this->json([
                'success' => false,
                'reason' => 'no token',
            ]);
        }
        
        if (!$this->isCsrfTokenValid('updatename', $submittedToken)) {
            return $this->json([
                'success' => false,
                'reason' => 'bad token',
            ]);
        }
        
        if (!$name = $request->query->get('name')) {
            return $this->json([
                'success' => false,
                'reason' => 'no name',
            ]);
        }
        
        $todolist->setName($name);
        $this->em->flush();
        return $this->json([
            'success' => true,
        ]);
    }
    
    /**
     * @Route("/add-item/{hash}", name="ADD_ITEM",options={"expose"=true})
     */
    public function addItem(Request $request, string $hash)
    {
        if (!$todolist = $this->todolistRepository->getByHash($hash)) {
            return $this->json([
                'success' => false,
                'reason' => 'no todolist',
            ]);
        }
        if (!$submittedToken = $request->query->get('token')) {
            return $this->json([
                'success' => false,
                'reason' => 'no token',
            ]);
        }
        
        if (!$this->isCsrfTokenValid('add-item', $submittedToken)) {
            return $this->json([
                'success' => false,
                'reason' => 'bad token',
            ]);
        }
        
        if (!$name = $request->query->get('name')) {
            return $this->json([
                'success' => false,
                'reason' => 'no name',
            ]);
        }
        
        $todolist->addItem(new Item($name));
        $this->em->flush();
        return $this->json([
            'success' => true,
            'html' => $this->renderView('includes/todolist-items.html.twig', [
                'todolist' => $todolist,
            ]),
        ]);
    }
    
    /**
     * @Route("/update-item/{hash}/{id}", name="UPDATE_ITEM",options={"expose"=true})
     */
    public function updateItem(Request $request, string $hash, int $id)
    {
        if (!$item = $this->itemRepository->getByHashAndIs($hash, $id)) {
            return $this->json([
                'success' => false,
                'reason' => 'no item',
            ]);
        }
//        if (!$submittedToken = $request->query->get('token')) {
//            return $this->json([
//                'success' => false,
//                'reason' => 'no token',
//            ]);
//        }
//
//        if (!$this->isCsrfTokenValid('update-item', $submittedToken)) {
//            return $this->json([
//                'success' => false,
//                'reason' => 'bad token',
//            ]);
//        }
        
        if (!$isChecked = $request->query->get('isChecked')) {
            return $this->json([
                'success' => false,
                'reason' => 'no ischecked',
            ]);
        }
    
        $item->setIsChecked($isChecked);
        $this->em->flush();
        return $this->json([
            'success' => true,
        ]);
    }
}
