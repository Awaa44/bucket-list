<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/wish', name: 'wish_')]
final class WishController extends AbstractController
{
    #[Route('/', name: 'app_list', methods: ['GET'])]
    public function list(): Response
    {
        return $this-> render('wish/list.html.twig');
    }

    #[Route('/{id}', name: 'app_detail', methods: ['GET'])]
    public function wishDetail(int $id): Response
    {
        return $this-> render('wish/detail.html.twig', [
            'wishId' => $id
        ]);
    }
}
