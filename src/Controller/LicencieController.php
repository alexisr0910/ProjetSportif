<?php

namespace App\Controller;

use App\Repository\LicencieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LicencieController extends AbstractController
{

    /**
     * Affiche les différents licenciés
     * 
     * @param LicencieRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/licencie', name: 'licencie', methods: ['GET'])]
    public function index(LicencieRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $licencie = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('Licencie/licencie.html.twig', [
            'licencie' => $licencie
        ]

        );
    }


}
