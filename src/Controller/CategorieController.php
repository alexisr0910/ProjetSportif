<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{

    /**
     * Affiche les différents contact
     * 
     * @param CategorieRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */


    #[Route('/categorie', name: 'categorie', methods: ['GET'])]
    public function index(CategorieRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $categorie = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('Categorie/categorie.html.twig', [
            'categorie' => $categorie
        ]

        );
    }


}
