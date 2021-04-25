<?php

namespace App\Controller;

use App\Repository\TemplateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(TemplateRepository $templateRepository): Response
    {
        return $this->render('contact/index.html.twig', [
            'templates' => $templateRepository->findMaxResults(4),
        ]);
    }
}
