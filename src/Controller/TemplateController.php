<?php

namespace App\Controller;

use Twig\Environment;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TemplateController extends AbstractController
{
    /**
     * @Route("/templates", name="templates")
     */
    public function templates(CategoryRepository $category): Response
    {
        return $this->render('template/templates.html.twig', [
            'categories' => $category->findAll(),
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
     * @Route("/template-category/{title}", name="template_category")
     */
    public function category(Category $category): Response
    {
        return $this->render('template/category.html.twig', [
            'category' => $category,
        ]);
    }
}
