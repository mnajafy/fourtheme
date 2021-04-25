<?php

namespace App\Controller;

use App\Repository\TemplateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(TemplateRepository $templateRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'templates' => $templateRepository->findMaxResults(3),
        ]);
    }
}
