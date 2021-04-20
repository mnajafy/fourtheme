<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Image;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class DashboardController extends AbstractDashboardController
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

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
            // ->setName($user->getUsername())
            // ->displayUserName(false)
            ->setAvatarUrl('build/img/fourtheme/user.svg')
            // ->displayUserAvatar(false)
            // ->setGravatarEmail($user->getEmail())

            // ->addMenuItems([
            //     MenuItem::linkToRoute('My Profile', 'fa fa-id-card', User::class),
            //     MenuItem::linkToRoute('Settings', 'fa fa-user-cog', User::class),
            //     MenuItem::section(),
            //     MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
            // ])
            ;
    }

    public function configureMenuItems(): iterable
    {
        return [
            // MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('Profile'),
            MenuItem::linkToCrud('Profile', 'fa fa-user', User::class)
                ->setAction('detail')
                ->setEntityId($this->getUser()->getId()),
            // MenuItem::subMenu('Profile', 'fa fa-user')->setSubItems([
            //     MenuItem::linkToCrud('Users', 'fa fa-user', User::class),
            //     MenuItem::linkToCrud('Edit username', 'fas fa-images', User::class),
            // ]),
            MenuItem::section('Users'),
            MenuItem::linkToCrud('Users', 'fas fa-list', User::class),
        ];
    }
}