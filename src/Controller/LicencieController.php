<?php

namespace App\Controller;
use App\Entity\Licencie;
use App\Entity\Educateur;
use App\Entity\Contact;
use App\Form\LicencieType;
use App\Repository\LicencieRepository;
use Doctrine\ORM\EntityManagerInterface;
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
        ]);
    }

    #[Route('/newLicencie', name: 'newLicencie', methods: ['GET', 'POST'])]
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

        return $this->render('Licencie/newLicencie.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/updateLicencie/{id}', name: 'updateLicencie', methods: ['GET', 'POST'])]
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

        return $this->render('Licencie/updateLicencie.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/deleteLicencie/{id}', name: 'deleteLicencie', methods: ['GET', 'POST'])]
    public function deleteLicencie(EntityManagerInterface $manager, Licencie $licencie): Response
    {
        $manager->remove($licencie);
        $manager->flush();
        $this->addFlash('success', 'Votre licencié a bien été supprimé');
        return $this->redirectToRoute('licencie');
    }
}
