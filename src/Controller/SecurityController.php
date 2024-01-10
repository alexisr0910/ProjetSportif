<?php

namespace App\Controller;

use App\Entity\Educateur;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('Backend/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/register', name: 'security.registration', methods: ['GET', 'POST'])]
    public function registration(Request $request, EntityManagerInterface $manager): Response
    {
        $educateur = new Educateur();
        $educateur->setRoles(['ROLE_ADMIN']);
        $form = $this->createForm(RegistrationFormType::class, $educateur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $educateur = $form->getData();
            $this->addFlash('success', 'Votre compte a bien été créé.');
            $manager->persist($educateur);
            $manager->flush();
            return $this->redirectToRoute('app_login');
        }
        return $this->render('Backend/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
