<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

  /**
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
