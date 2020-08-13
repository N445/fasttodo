<?php

namespace App\Controller;

use App\Repository\TodolistRepository;
use App\Service\TodolistCreator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="HOMEPAGE")
     */
    public function index()
    {
        return $this->render('default/index.html.twig', [
        ]);
    }
    
    /**
     * @Route("/create", name="CREATE",methods={"POST"})
     */
    public function create(Request $request, TodolistCreator $todolistCreator)
    {
        if (!$submittedToken = $request->request->get('token')) {
            return $this->redirectToRoute('HOMEPAGE');
        }
        
        // 'delete-item' is the same value used in the template to generate the token
        if (!$this->isCsrfTokenValid('create', $submittedToken)) {
            return $this->redirectToRoute('HOMEPAGE');
        }
        return $this->redirectToRoute('TODOLIST', [
            'hash' => $todolistCreator->createTodolist()->getHash(),
        ]);
    }
    
    /**
     * @Route("/todolist/{hash}", name="TODOLIST")
     */
    public function todolist(string $hash, TodolistRepository $todolistRepository)
    {
        if (!$hash) {
            return $this->redirectToRoute('HOMEPAGE');
        }
        if (!$todolist = $todolistRepository->getByHash($hash)) {
            return $this->redirectToRoute('HOMEPAGE');
        }
        return $this->render('default/todolist.html.twig', [
            'todolist' => $todolist,
        ]);
    }
    
}
