<?php

namespace App\Controller;

use App\Repository\LicencieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController extends AbstractController
{/**
 * Affiche la page home
 *
 * @return Response
 */
    #[Route("/", name: "home", methods: ["GET", "POST"])]
    public function home(): Response
    {
        return $this->render('pages/home.html.twig');
    }
}
