<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Security\Voter\UserVoter;
use Symfony\Component\Security\Core\Security;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class UserCrudController extends AbstractCrudController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('username'),
            EmailField::new('email')->hideOnIndex(),
            TelephoneField::new('phoneNumber')->hideOnIndex(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $detail = Action::new('Detail', null, 'fas fa-eye')
            ->setLabel(false)
                ->linkToCrudAction('detail')
                ->setCssClass('btn btn-success')
            ;

        return $actions
            ->add(Crud::PAGE_INDEX, $detail)
            ->add(Crud::PAGE_EDIT, $detail)
        // update
            ->update(Crud::PAGE_DETAIL, Action::EDIT, function (Action $action) {
                return $action
                    ->setIcon('fas fa-edit')->setLabel(false)
                    ->displayIf(fn (User $user) => $this->security->isGranted(UserVoter::EDIT, $user));
            })
            ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                return $action
                    ->setCssClass('btn btn-danger')
                    ->setLabel(false)
                    ->displayIf(fn (User $user) => $this->security->isGranted(UserVoter::DELETE, $user));
            })
            // remove
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->remove(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE)
        ; 
    }
}
