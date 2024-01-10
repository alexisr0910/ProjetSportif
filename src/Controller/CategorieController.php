<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Model\SearchData;
use App\Repository\CategorieRepository;
use App\Repository\LicencieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class CategorieController extends AbstractController
{

    /**
     * Redirection et affichages des valeurs 
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
            5
        );

        return $this->render('Backend/Categorie/categorie.html.twig', [
            'categorie' => $categorie
        ]);
    }
    /**
     * Création d'une catégorie 
     *
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    #[Route('/newCategorie', name: 'newCategorie', methods: ['GET', 'POST'])]
    #[Security('is_granted("ROLE_ADMIN")')]
    public function newCategorie(EntityManagerInterface $manager, Request $request): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categorie = $form->getData();
            $manager->persist($categorie);
            $manager->flush();

            $this->addFlash('success', 'Votre catégorie a bien été créée');
            return $this->redirectToRoute('categorie');
        }

        return $this->render('Backend/Categorie/newCategorie.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * Modification d'une catégorie
     *
     * @param Categorie $categorie
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    #[Route('/updateCategorie/{id}', name: 'updateCategorie', methods: ['GET', 'POST'])]
    #[Security('is_granted("ROLE_ADMIN")')]
    public function updateCategorie(Categorie $categorie, EntityManagerInterface $manager, Request $request): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categorie = $form->getData();
            $manager->persist($categorie);
            $manager->flush();

            $this->addFlash('success', 'Votre catégorie a bien été modifiée');
            return $this->redirectToRoute('categorie');
        }

        return $this->render('Backend/Categorie/updateCategorie.html.twig', ['form' => $form->createView(),]);
    }

    /**
     * Suppresion d'une catégorie 
     *
     * @param EntityManagerInterface $manager
     * @param Categorie $categorie
     * @return Response
     */
    #[Route('/deleteCategorie/{id}', name: 'deleteCategorie', methods: ['GET', 'POST'])]
    #[Security('is_granted("ROLE_ADMIN")')]
    public function deleteCategorie(EntityManagerInterface $manager, Categorie $categorie): Response
    {
        $manager->remove($categorie);
        $manager->flush();
        $this->addFlash('success', 'Votre categorie a bien été supprimée');
        return $this->redirectToRoute('categorie');
    }

    

}