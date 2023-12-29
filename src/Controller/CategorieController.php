<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{

    /**
     * Affiche les différentes catégories
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

    #[Route('/newCategorie', name: 'newCategorie', methods: ['GET', 'POST'])]
    public function newCategorie(EntityManagerInterface $manager,
        Request $request): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categorie = $form->getData();
            $manager->persist($categorie);
            $manager->flush();

            $this->addFlash('success', 'Votre catégorie à bien été créer');
            return $this->redirectToRoute('categorie');
        }

        return $this->render('Categorie/newCategorie.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/updateCategorie/{id}', name: 'updateCategorie', methods: ['GET', 'POST'])]

    public function updateCategorie(Categorie $categorie, EntityManagerInterface $manager,
        Request $request): Response
    {

        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categorie = $form->getData();
            $manager->persist($categorie);
            $manager->flush();

            $this->addFlash('success', 'Votre catégorie à bien été modifier');
            return $this->redirectToRoute('categorie');
        }

        return $this->render('Categorie/updateCategorie.html.twig', ['form' => $form->createView(),]);
    }
    #[Route('/deleteCategorie/{id}', name: 'deleteCategorie', methods: ['GET', 'POST'])]
    public function deleteCategorie(EntityManagerInterface $manager, Categorie $categorie): Response
    {
        $manager->remove($categorie);
        $manager->flush();
        $this->addFlash('success', 'Votre categorie à bien été supprimer');
        return $this->redirectToRoute('categorie');
    }
}




