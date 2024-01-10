<?php

namespace App\Controller;

use App\Entity\MailContact;
use App\Form\MailContactType;
use App\Repository\MailContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class MailContactController extends AbstractController
{

    #[Route('/mailcontact', name: 'mailcontact', methods: ['GET'])]
    public function index(MailContactRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $mailcontact = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('Frontend/MailContact/mailcontact.html.twig', [
            'mailcontact' => $mailcontact
        ]);
    }


    #[Route('/newMailContact', name: 'newMailContact', methods: ['GET', 'POST'])]
    #[Security("is_granted('ROLE_ADMIN')", "is_granted('ROLE_EDUCATEUR')")]

    public function newMailContact(EntityManagerInterface $manager, Request $request): Response
    {
        $mailcontact = new MailContact();
        $mailcontact->setDateEnvoi(new \DateTime());
        $form = $this->createForm(MailContactType::class, $mailcontact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $mailcontact = $form->getData();
            $manager->persist($mailcontact);
            $manager->flush();

            $this->addFlash('success', 'Votre mail a bien été envoyé');
            return $this->redirectToRoute('mailcontact');
        }

        return $this->render('Frontend/MailContact/newMailContact.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/deleteMailContact/{id}', name: 'deletemailcontact', methods: ['GET', 'POST'])]
    #[Security("is_granted('ROLE_ADMIN')", "is_granted('ROLE_EDUCATEUR')")]
    public function deleteMailContact(EntityManagerInterface $manager, MailContact $mailcontact): Response
    {
        $manager->remove($mailcontact);
        $manager->flush();
        $this->addFlash('success', 'Votre mail a bien été supprimé');
        return $this->redirectToRoute('mailcontact');
    }

}