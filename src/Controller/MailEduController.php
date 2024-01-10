<?php

namespace App\Controller;

use App\Entity\MailEdu;
use App\Form\MailEduType;
use App\Repository\MailEduRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class MailEduController extends AbstractController
{
    #[Route('/mailedu', name: 'mailedu', methods: ['GET'])]
    public function index(MailEduRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $mailedu = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('Frontend/MailEdu/mailedu.html.twig', [
            'mailedu' => $mailedu
        ]);
    }

    #[Route('/newMailEdu', name: 'newMailEdu', methods: ['GET', 'POST'])]
    #[Security("is_granted('ROLE_ADMIN')", "is_granted('ROLE_EDUCATEUR')")]

    public function newMailEdu(EntityManagerInterface $manager, Request $request): Response
    {
        $mailedu = new MailEdu();
        $mailedu->setDateEnvoie(new \DateTime());
        $form = $this->createForm(MailEduType::class, $mailedu);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $mailedu = $form->getData();
            $manager->persist($mailedu);
            $manager->flush();

            $this->addFlash('success', 'Votre mail a bien été envoyé');
            return $this->redirectToRoute('mailedu');
        }

        return $this->render('Frontend/MailEdu/newMailEdu.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/deleteMailEdu/{id}', name: 'deletemailedu', methods: ['GET', 'POST'])]
    #[Security("is_granted('ROLE_ADMIN')", "is_granted('ROLE_EDUCATEUR')")]
    public function deleteMailEdu(EntityManagerInterface $manager, MailEdu $mailedu): Response
    {
        $manager->remove($mailedu);
        $manager->flush();
        $this->addFlash('success', 'Votre mail a bien été supprimé');
        return $this->redirectToRoute('mailedu');
    }

}

