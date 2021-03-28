<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TemplateController extends AbstractController
{
    /**
     * @Route("/templates", name="templates")
     */
    public function templates(): Response
    {
        return $this->render('template/templates.html.twig', [

        ]);
    }
    /**
     * @Route("/template", name="template")
     */
    public function template(): Response
    {
        return $this->render('template/template.html.twig', []);
    }
    /**
     * @Route("/template-category", name="template_category")
     */
    public function category(): Response
    {
        return $this->render('template/category.html.twig', []);
    }
}
