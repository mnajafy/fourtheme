<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Image;
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
        ];
    }
}