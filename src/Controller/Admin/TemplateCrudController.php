<?php

namespace App\Controller\Admin;

use App\Form\ImageType;
use App\Entity\Template;
use App\Security\Voter\TemplateVoter;
use Symfony\Component\Security\Core\Security;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

class TemplateCrudController extends AbstractCrudController
{
    private $security;
    private $params;

    public function __construct(ParameterBagInterface $params, Security $security)
    {
        $this->params = $params;
        $this->security = $security;
    }
    
    public static function getEntityFqcn(): string
    {
        return Template::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title'),
            TextField::new('author')->hideOnForm(),
            TextField::new('summary')->hideOnIndex(),
            TextEditorField::new('content')->hideOnIndex(),
            AssociationField::new('categories')->hideOnDetail(),
            ArrayField::new('categories')->onlyOnDetail(),
            AssociationField::new('images')->onlyOnIndex(),
            CollectionField::new('images')
                ->setEntryType(ImageType::class)
                ->onlyOnForms(),
            CollectionField::new('images')
                ->setEntryType(VichImageType::class)
                ->setTemplatePath('admin/field/images.html.twig')
                ->onlyOnDetail(),
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
                    ->displayIf(fn (Template $template) => $this->security->isGranted(TemplateVoter::EDIT, $template));
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action
                    ->setIcon('fas fa-trash-alt')
                    ->setLabel(false)
                    ->setCssClass('btn btn-danger')
                    ->displayIf(fn (Template $template) => $this->security->isGranted(TemplateVoter::DELETE, $template));
            })
            ->update(Crud::PAGE_DETAIL, Action::EDIT, function (Action $action) {
                return $action
                    ->setIcon('fas fa-edit')->setLabel(false)
                    ->displayIf(fn (Template $template) => $this->security->isGranted(TemplateVoter::EDIT, $template));
            })
            ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                return $action
                    ->setLabel(false)
                    ->setCssClass('btn btn-danger')
                    ->displayIf(fn (Template $template) => $this->security->isGranted(TemplateVoter::DELETE, $template));
            })
            // remove
            ->remove(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE);
    }
}
