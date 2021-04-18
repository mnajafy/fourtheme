<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Image;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
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
            ->setTitle('Fourtheme');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            // MenuItem::section('Profile'),
            MenuItem::subMenu('Profile', 'fa fa-user')->setSubItems([
                MenuItem::linkToCrud('Profile', 'fa fa-user', User::class)
                    ->setAction('detail')
                    ->setEntityId($this->getUser()->getId()),
                MenuItem::linkToCrud('Edit username', 'fa fa-user', User::class)
                    ->setAction('editUsername')
                    ->set
                    ->setEntityId($this->getUser()->getId()),
                // MenuItem::linkToCrud('Edit username', 'fas fa-images', User::class),
            ]),
            //     MenuItem::linkToCrud('Users', 'fa fa-user', User::class),
            MenuItem::linkToCrud('Users', 'fa fa-user', User::class),
        ];
    }
}