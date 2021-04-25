<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Template;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Core\User\UserInterface;
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
            ->setTitle('<img src="build/img/fourtheme/logo.png" class="img-fluid d-inline-block mr-2" alt=""/>Fourtheme');
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->setAvatarUrl('build/img/fourtheme/user.svg')

            ->addMenuItems([
                MenuItem::linkToCrud('My Profile', 'fa fa-id-card', User::class)
                    ->setAction('detail')
                    ->setEntityId($this->getUser()->getId()),
                MenuItem::linkToCrud('Settings', 'fa fa-user-cog', User::class)
                    ->setAction('edit')
                    ->setEntityId($this->getUser()->getId()),
            ]);
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('users'),
            MenuItem::linkToCrud('Users', 'fas fa-users', User::class),
            MenuItem::section('Templates'),
            MenuItem::linkToCrud('Templates', 'fas fa-folder-open', Template::class),
            MenuItem::linkToCrud('Categories', 'fas fa-clipboard-list', Category::class),
            MenuItem::linkToCrud('Images', 'fas fa-images', Image::class),
        ];
    }
}
