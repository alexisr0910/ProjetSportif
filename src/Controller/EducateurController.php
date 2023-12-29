<?php

namespace App\Controller;

use App\Repository\EducateurRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EducateurController extends AbstractController
{

     /**
     * Affiche les différents educateur
     * 
     * @param EducateurRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */


    #[Route('/educateur', name: 'educateur', methods: ['GET'])]
    public function index(EducateurRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $educateur = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('Educateur/educateur.html.twig', [
            'educateur' => $educateur
        ]

        );
    }


}
