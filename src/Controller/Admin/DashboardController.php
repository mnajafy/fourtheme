<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Fourtheme');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('User'),
            MenuItem::subMenu('Users', 'fa fa-user')->setSubItems([
                MenuItem::linkToCrud('Users', 'fa fa-user', User::class),
                MenuItem::linkToCrud('Images', 'fas fa-images', Image::class),
            ]),
            // MenuItem::section('Blog'),
            // MenuItem::linkToCrud('Categories', 'fa fa-tags', Category::class),
            // MenuItem::linkToCrud('Blog Posts', 'fa fa-file-text', BlogPost::class),
            // MenuItem::linkToCrud('Comments', 'fa fa-comment', Comment::class),
        ];
    }
}
