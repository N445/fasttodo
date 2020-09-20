<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class PublishController extends AbstractController
{
    public function __invoke(MessageBusInterface $bus): Response
    {
        $update = new Update(
            'http://example.com/books/1',
            json_encode(['status' => 'OutOfStock'])
        );
        
        // The Publisher service is an invokable object
        // $publisher($update);
        $bus->dispatch($update);
        
        return new Response('published!');
    }
}
