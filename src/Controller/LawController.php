<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LawController extends AbstractController
{
    /**
     * @Route("/law", name="law")
     */
    public function index(): Response
    {
        return $this->render('law/index.html.twig', [
            'controller_name' => 'LawController',
        ]);
    }
    /**
     * @Route("/complain", name="complain")
     */
    public function complain(): Response
    {
        return $this->render('law/complain.html.twig', [
            
        ]);
    }
}
