<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Security\Voter\ImageVoter;
use Vich\UploaderBundle\Form\Type\VichFileType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Security;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ImageCrudController extends AbstractCrudController
{
    private $params;
    private $security;

    public function __construct(ParameterBagInterface $params, Security $security)
    {
        $this->params = $params;
        $this->security = $security;
    }

    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // yield VichImageType
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('author')->hideOnForm(),
            DateTimeField::new('createdAt')->onlyOnDetail(),
            DateTimeField::new('UpdatedAt')->onlyOnDetail(),
            Field::new('imageFile', 'Image')
                ->onlyOnForms()
                ->setFormType(VichImageType::class)
                ->setFormTypeOptions([])
            ,
            ImageField::new('image')
                ->setFormType(VichImageType::class)
                ->hideOnForm()
                ->setBasePath($this->params->get('app.path.uploads_images'))
        ];
    }
    public function editBtn($entity){
        $this->denyAccessUnlessGranted(ImageVoter::EDIT, $entity);
    }

    public function configureActions(Actions $actions): Actions
    {
            $edit = Action::new('Edit', null, 'fas fa-file-invoice')
                ->setLabel(false)
                ->setCssClass('btn btn-info text-white')
                ->displayIf(fn (Image $entity) => $this->security->isGranted(ImageVoter::EDIT, $entity))
                    ->linkToCrudAction('edit');
            $delete = Action::new('Delete', null, 'fas fa-trash-alt')
                ->setCssClass('btn btn-danger text-white')
                ->setLabel(false)
                ->displayIf(fn (Image $entity) => $this->security->isGranted(ImageVoter::DELETE, $entity))
                    ->linkToCrudAction('delete');

        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setCssClass('btn btn-success text-white')->setIcon('far fa-eye')->setLabel(false);
            })
            ->add(Crud::PAGE_INDEX, $edit)
            ->remove(crud::PAGE_INDEX, Action::EDIT)
            ->add(Crud::PAGE_INDEX, $delete)
            ->remove(crud::PAGE_INDEX, Action::DELETE)
        ;
    }

    // public function configureCrud(Crud $crud): Crud
    // {
    //     return $crud
    //         ->showEntityActionsAsDropdown();
    // }
}
