<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class IndexController extends AbstractController

{
    /**
     * @Route("/home/" , name="home",
    methods={"GET","POST"})
     */

    public function home(Environment $twig): Response
    {
        $html = $twig->render('base.html.twig');
        return new Response($html);
    }
}
