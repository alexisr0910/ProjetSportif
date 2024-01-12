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

    /**
     * Se connecter
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('Backend/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * Se déconnecter
     *
     * @return void
     */
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * Création d'un nouveau compte
     *
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
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
