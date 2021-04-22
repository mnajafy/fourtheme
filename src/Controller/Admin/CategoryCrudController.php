<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Security\Voter\CategoryVoter;
use Symfony\Component\Security\Core\Security;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoryCrudController extends AbstractCrudController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title'),
            TextField::new('summary'),
            TextEditorField::new('content')->hideOnIndex(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::DETAIL)
            // update
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
            return $action
                ->setCssClass('btn btn-success')
                ->setIcon('fas fa-eye')
                ->setLabel(false);
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action
                    ->setCssClass('btn btn-info')
                    ->setIcon('fas fa-edit')->setLabel(false)
                    ->displayIf(fn (Category $category) => $this->security->isGranted(CategoryVoter::EDIT, $category));
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action
                    ->setIcon('fas fa-trash-alt')
                    ->setLabel(false)
                    ->setCssClass('btn btn-danger')
                    ->displayIf(fn (Category $category) => $this->security->isGranted(CategoryVoter::DELETE, $category));
            })
            ->update(Crud::PAGE_DETAIL, Action::EDIT, function (Action $action) {
                return $action
                    ->setIcon('fas fa-edit')->setLabel(false)
                    ->displayIf(fn (Category $category) => $this->security->isGranted(CategoryVoter::EDIT, $category));
            })
            ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                return $action
                    ->setLabel(false)
                    ->setCssClass('btn btn-danger')
                    ->displayIf(fn (Category $category) => $this->security->isGranted(CategoryVoter::DELETE, $category));
            })
            // remove
            ->remove(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE)
        ;
    }
}
