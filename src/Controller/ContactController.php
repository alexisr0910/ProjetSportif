<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

    /**
     * Affiche les différents contact
     * 
     * @param ContactRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */


    #[Route('/contact', name: 'contact', methods: ['GET'])]
    public function index(ContactRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $contact = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('Contact/contact.html.twig', [
            'contact' => $contact
        ]

        );
    }
    #[Route('/newContact', name: 'newContact', methods: ['GET', 'POST'])]
    public function newContact(EntityManagerInterface $manager,
        Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $manager->persist($contact);
            $manager->flush();

            $this->addFlash('success', 'Votre contact à bien été créer');
            return $this->redirectToRoute('contact');
        }

        return $this->render('Contact/newContact.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/updateContact/{id}', name: 'updateContact', methods: ['GET', 'POST'])]

    public function updateContact(Contact $contact, EntityManagerInterface $manager,
        Request $request): Response
    {

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $manager->persist($contact);
            $manager->flush();

            $this->addFlash('success', 'Votre contact à bien été modifier');
            return $this->redirectToRoute('contact');
        }

        return $this->render('Contact/updateContact.html.twig', ['form' => $form->createView(),]);
    }
    #[Route('/deleteContact/{id}', name: 'deleteContact', methods: ['GET', 'POST'])]
    public function deleteContact(EntityManagerInterface $manager, Contact $contact): Response
    {
        $manager->remove($contact);
        $manager->flush();
        $this->addFlash('success', 'Votre contact à bien été supprimer');
        return $this->redirectToRoute('contact');
    }
}
