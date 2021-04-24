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
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

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
            TextField::new('author')->hideOnForm(),
            TextField::new('summary')->hideOnIndex(),
            TextEditorField::new('content')->hideOnIndex(),
            AssociationField::new('images')->hideOnForm(),
            AssociationField::new('templates')->hideOnForm(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $detail = Action::new('Detail', null, 'fas fa-eye')
        ->setLabel(false)
            ->linkToCrudAction('detail')
            ->setCssClass('btn btn-success');

        return $actions
            ->add(Crud::PAGE_INDEX, $detail)
            ->add(Crud::PAGE_EDIT, $detail)
            // update
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
