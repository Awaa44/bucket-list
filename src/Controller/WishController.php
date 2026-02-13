<?php

namespace App\Controller;

use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/wish', name: 'app_wish')]
final class WishController extends AbstractController
{
    #[Route('/', name: '_list', methods: ['GET'])]
    public function list(WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findBy(['isPublished' => true], ['dateCreated' => 'DESC']);

        return $this-> render('wish/list.html.twig', [
            'wishes' => $wishes,
        ]);
    }

    #[Route('/{id}', name: '_detail', requirements: ['id'=> '\d+'], methods: ['GET'])]
    public function wishDetail(WishRepository $wishRepository, int $id): Response
    {
        $wish = $wishRepository->findOneBy(['id' => $id]);

        //affichage page 404
        if(!$wish){
            throw $this->createNotFoundException('Ce souhait n\'existe pas');
        }

        return $this-> render('wish/detail.html.twig', [
            'wish' => $wish
        ]);
    }
}
