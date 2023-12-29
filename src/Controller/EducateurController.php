<?php

namespace App\Controller;

use App\Entity\Educateur;
use App\Form\EducateurType;
use App\Repository\EducateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EducateurController extends AbstractController
{
    /**
     * Affiche les différents éducateurs
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
        ]);
    }

    #[Route('/newEducateur', name: 'newEducateur', methods: ['GET', 'POST'])]
    public function newEducateur(EntityManagerInterface $manager, Request $request): Response
    {
        $educateur = new Educateur();
        $form = $this->createForm(EducateurType::class, $educateur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $educateur = $form->getData();
            $manager->persist($educateur);
            $manager->flush();

            $this->addFlash('success', 'Votre éducateur a bien été créé');
            return $this->redirectToRoute('educateur');
        }

        return $this->render('Educateur/newEducateur.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/updateEducateur/{id}', name: 'updateEducateur', methods: ['GET', 'POST'])]
    public function updateEducateur(Educateur $educateur, EntityManagerInterface $manager, Request $request): Response
    {
        $form = $this->createForm(EducateurType::class, $educateur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $educateur = $form->getData();
            $manager->persist($educateur);
            $manager->flush();

            $this->addFlash('success', 'Votre éducateur a bien été modifié');
            return $this->redirectToRoute('educateur');
        }

        return $this->render('Educateur/updateEducateur.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/deleteEducateur/{id}', name: 'deleteEducateur', methods: ['GET', 'POST'])]
    public function deleteEducateur(EntityManagerInterface $manager, Educateur $educateur): Response
    {
        $manager->remove($educateur);
        $manager->flush();
        $this->addFlash('success', 'Votre éducateur a bien été supprimé');
        return $this->redirectToRoute('educateur');
    }
}
