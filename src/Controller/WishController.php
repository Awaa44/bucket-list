<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Config\Doctrine\Orm\EntityManagerConfig;

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

    #[IsGranted("ROLE_USER")]
    #[Route('/create', name: '_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $wish = new Wish();
        $wishForm = $this->createForm(WishType::class, $wish);

        $wishForm->handleRequest($request);

        if($wishForm->isSubmitted() && $wishForm->isValid()){
            //date du jour
            //$wish->setDateCreated(new \DateTime());
            //associer l'utilisateur connecté
            $wish->setUsername($this->getUser());
            //enregistrement dans la base de données
            $em->persist($wish);
            $em->flush();

            //message de succès
            $message = 'Votre souhait a été enregistré';
            $this->addFlash('success', $message);
            //redirection vers la liste des souhaits vers le détail du souhait
            return $this->redirectToRoute('app_wish_detail', ['id' => $wish->getId()]);
        }

        return $this-> render('wish/edit.html.twig', [
            'wish_form' => $wishForm,
        ]);
    }

    #[IsGranted("ROLE_USER")]
    #[Route('/update/{id}', name: '_update', requirements: ['id'=> '\d+'])]
    public function update(Request $request, EntityManagerInterface $em, Wish $wish): Response
    {
        $wishForm = $this->createForm(WishType::class, $wish);
        $wishForm->handleRequest($request);

        if($wishForm->isSubmitted() && $wishForm->isValid()
            && ($this->getUser() === $wish->getUsername() || $this->isGranted('ROLE_ADMIN'))){
            //enregistrement dans la base de données
            $em->flush();

            //message de succès
            $message = 'Votre souhait a bien été modifié';
            $this->addFlash('success', $message);
            //redirection vers la liste des souhaits vers le détail du souhait
            return $this->redirectToRoute('app_wish_detail', ['id' => $wish->getId()]);
        }

        return $this-> render('wish/edit.html.twig', [
            'wish_form' => $wishForm,
            'wish' => $wish,
        ]);
    }

    #[IsGranted("ROLE_USER")]
    #[Route('/delete/{id}', name: '_delete', requirements: ['id'=> '\d+'])]
    public function delete(Wish $wish, EntityManagerInterface $em, Request $request): Response
    {
        //récupération du token de sécurité
        $token = $request->query->get('token');

        if ($this->isCsrfTokenValid('delete'.$wish->getId(), $token)
            && ($this->getUser() === $wish->getUsername() || $this->isGranted('ROLE_ADMIN'))) {
            $em->remove($wish);
            $em->flush();

            $this->addFlash('success', 'Votre souhait a été supprimé avec succès');
            return $this->redirectToRoute('app_wish_list');
        }

        $this->addFlash('danger', message: 'Impossible de supprimer le souhait');
        return $this->redirectToRoute('app_wish_detail', ['id' => $wish->getId()]);
    }
}
