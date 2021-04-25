<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TemplateController extends AbstractController
{
    /**
     * @Route("/templates", name="templates")
     */
    public function templates(): Response
    {
        return $this->render('template/templates.html.twig');
    }
    /**
     * @Route("/template/{title}", name="template")
     */
    public function template(Template $template): Response
    {
        return $this->render('template/template.html.twig', [
            'template' => $template,
        ]);
    }
    /**
     * @Route("/template-category/{title}", name="template_category")
     */
    public function category(Category $category): Response
    {
        return $this->render('template/category.html.twig', [
            'category' => $category,
        ]);
    }
}
