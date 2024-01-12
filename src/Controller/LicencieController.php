<?php

namespace App\Controller;

use App\Entity\Licencie;
use App\Form\LicencieType;
use App\Repository\CategorieRepository;
use App\Repository\LicencieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;



class LicencieController extends AbstractController
{
    /**
     * Redirection et affichages des valeurs 
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
            5
        );

        return $this->render('Backend/Licencie/licencie.html.twig', [
            'licencie' => $licencie
        ]);
    }

    /**
     * Création d'un nouveau licencié
     *
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    #[Route('/newLicencie', name: 'newLicencie', methods: ['GET', 'POST'])]
    #[Security('is_granted("ROLE_ADMIN")')]
    public function newLicencie(EntityManagerInterface $manager, Request $request): Response
    {
        $licencie = new Licencie();
        $licencie->setNumLicence(mt_rand(1000, 9999));

        $form = $this->createForm(LicencieType::class, $licencie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $licencie = $form->getData();
            $manager->persist($licencie);
            $manager->flush();

            $this->addFlash('success', 'Votre licencié a bien été créé');
            return $this->redirectToRoute('licencie');
        }

        return $this->render('Backend/Licencie/newLicencie.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Modification d'un licencié
     *
     * @param Licencie $licencie
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    #[Route('/updateLicencie/{id}', name: 'updateLicencie', methods: ['GET', 'POST'])]
    #[Security('is_granted("ROLE_ADMIN")')]
    public function updateLicencie(Licencie $licencie, EntityManagerInterface $manager, Request $request): Response
    {
        $form = $this->createForm(LicencieType::class, $licencie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $licencie = $form->getData();
            $manager->persist($licencie);
            $manager->flush();

            $this->addFlash('success', 'Votre licencié a bien été modifié');
            return $this->redirectToRoute('licencie');
        }

        return $this->render('Backend/Licencie/updateLicencie.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Suppression d'un licencié
     *
     * @param EntityManagerInterface $manager
     * @param Licencie $licencie
     * @return Response
     */
    #[Route('/deleteLicencie/{id}', name: 'deleteLicencie', methods: ['GET', 'POST'])]
    #[Security('is_granted("ROLE_ADMIN")')]
    public function deleteLicencie(EntityManagerInterface $manager, Licencie $licencie): Response
    {
        $manager->remove($licencie);
        $manager->flush();
        $this->addFlash('success', 'Votre licencié a bien été supprimé');
        return $this->redirectToRoute('licencie');
    }

    /**
     * Affichage des licenciés par catégorie
     *
     * @param Request $request
     * @param CategorieRepository $categorieRepository
     * @return Response
     */
    #[Route('/licenciesParCategorie', name: 'licenciesParCategorie')]
    public function licenciesParCategorie(Request $request, CategorieRepository $categorieRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $categories = $categorieRepository->findAll();
        $categoryId = $request->query->get('category');
        $selectedCategory = null;
        $licencies = [];

        if ($categoryId) {
            $selectedCategory = $categorieRepository->find($categoryId);
            if ($selectedCategory) {
                $licencies = $selectedCategory->getLicencies();
            }
        }

        return $this->render('Frontend/licenciesParCategorie.html.twig', [
            'categories' => $categories,
            'licencies' => $licencies,
            'selectedCategory' => $selectedCategory ?? null,
        ]);
    }




}
