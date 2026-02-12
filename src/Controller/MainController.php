<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function home(): Response
    {
        return $this-> render('home/home.html.twig');
    }

    #[Route('/about-us', name: 'app_about_us', methods: ['GET'])]
    public function aboutUs(): Response
    {
        return $this-> render('home/about-us.html.twig');
    }
}
