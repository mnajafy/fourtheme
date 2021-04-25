<?php

namespace App\Controller;

use App\Repository\TemplateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(TemplateRepository $templateRepository): Response
    {
        return $this->render('blog/index.html.twig', [
            'templates' => $templateRepository->findCreatedAt(),
        ]);
    }
}
