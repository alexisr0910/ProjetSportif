<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\CategorieRepository;
use App\Repository\ContactRepository;
use App\Repository\LicencieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ContactController extends AbstractController
{

    /**
     * Redirection et affichages des valeurs 
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
            5
        );

        return $this->render('Backend/Contact/contact.html.twig', [
            'contact' => $contact
        ]);
    }

    /**
     * Création d'un nouveau contact
     *
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    #[Route('/newContact', name: 'newContact', methods: ['GET', 'POST'])]
    #[Security('is_granted("ROLE_ADMIN")')]
    public function newContact(EntityManagerInterface $manager, Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $manager->persist($contact);
            $manager->flush();

            $this->addFlash('success', 'Votre contact a bien été créé');
            return $this->redirectToRoute('contact');
        }

        return $this->render('Backend/Contact/newContact.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Modification d'un contact
     *
     * @param Contact $contact
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    #[Route('/updateContact/{id}', name: 'updateContact', methods: ['GET', 'POST'])]
    #[Security('is_granted("ROLE_ADMIN")')]
    public function updateContact(Contact $contact, EntityManagerInterface $manager, Request $request): Response
    {
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $manager->persist($contact);
            $manager->flush();

            $this->addFlash('success', 'Votre contact a bien été modifié');
            return $this->redirectToRoute('contact');
        }

        return $this->render('Backend/Contact/updateContact.html.twig', ['form' => $form->createView(),]);
    }

    /**
     * Suppression d'un contact
     *
     * @param EntityManagerInterface $manager
     * @param Contact $contact
     * @return Response
     */
    #[Route('/deleteContact/{id}', name: 'deleteContact', methods: ['GET', 'POST'])]
    #[Security('is_granted("ROLE_ADMIN")')]
    public function deleteContact(EntityManagerInterface $manager, Contact $contact): Response
    {
        $manager->remove($contact);
        $manager->flush();
        $this->addFlash('success', 'Votre contact a bien été supprimé');
        return $this->redirectToRoute('contact');
    }


    #[Route('/contactParCategorie', name: 'contactParCategorie')]
    public function contactParCategorie(Request $request, CategorieRepository $categorieRepository, LicencieRepository $licencieRepository, ContactRepository $contactRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $categories = $categorieRepository->findAll();
        $categoryId = $request->query->get('category');
        $selectedCategory = null;
        $contacts = [];
       

        if ($categoryId) {
            $selectedCategory = $categorieRepository->find($categoryId);
            if ($selectedCategory) {
                foreach ($selectedCategory->getLicencies() as $licencie) {
                    foreach ($licencie->getContacts() as $contact) {
                        $contacts[] = $contact;
                    }
                }
                
            }
        }
        
        return $this->render('Frontend/contactParCategorie.html.twig', [
            'categories' => $categories,
            'contacts' => $contacts,
            'selectedCategory' => $selectedCategory ?? null,
        ]);
    }

}
