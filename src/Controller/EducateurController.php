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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class EducateurController extends AbstractController
{

    /**
     * Redirection et affichages des valeurs 
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

    /**
     * Création d'un nouveau éducateur 
     *
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
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

    /**
     * Modification d'un éducateur
     *
     * @param Educateur $educateur
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    #[Route('/updateEducateur/{id}', name: 'updateEducateur', methods: ['GET', 'POST'])]
    #[Security('is_granted("ROLE_ADMIN")')]
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

    /**
     * Suppression d'un éducateur 
     *
     * @param EntityManagerInterface $manager
     * @param Educateur $educateur
     * @return Response
     */
    #[Route('/deleteEducateur/{id}', name: 'deleteEducateur', methods: ['GET', 'POST'])]
    #[Security('is_granted("ROLE_ADMIN")')]
    public function deleteEducateur(EntityManagerInterface $manager, Educateur $educateur): Response
    {
        $manager->remove($educateur);
        $manager->flush();
        $this->addFlash('success', 'Votre éducateur a bien été supprimé');
        return $this->redirectToRoute('educateur');
    }
}
