<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Security\Voter\ImageVoter;
use Symfony\Component\Security\Core\Security;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ImageCrudController extends AbstractCrudController
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
        return Image::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('author')->hideOnForm(),
            Field::new('imageFile')
                ->onlyOnForms()
                ->setFormType(VichImageType::class),
            ImageField::new('image')
                ->setBasePath($this->params->get('app.path.uploads_images'))
                ->hideOnForm()
                ->setFormType(VichImageType::class),
            AssociationField::new('categories')->hideOnDetail(),
            ArrayField::new('categories')->onlyOnDetail(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $detail = Action::new('Detail', null, 'fas fa-eye')
            ->setLabel(false)
            ->linkToCrudAction('detail')
            ->setCssClass('btn btn-success')
            ->displayIf(fn (Image $image) => $this->security->isGranted(ImageVoter::EDIT, $image))
        ;
        return $actions
            ->add(Crud::PAGE_INDEX, $detail)
            ->add(Crud::PAGE_EDIT, $detail)
            // update
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action
                    ->setCssClass('btn btn-info')
                    ->setIcon('fas fa-edit')->setLabel(false)
                    ->displayIf(fn (Image $image) => $this->security->isGranted(ImageVoter::EDIT, $image))
                ;
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action
                    ->setCssClass('btn btn-danger')
                    ->setIcon('fas fa-trash-alt')->setLabel(false)
                    ->displayIf(fn (Image $image) => $this->security->isGranted(ImageVoter::EDIT, $image));
            })
            ->update(Crud::PAGE_DETAIL, Action::EDIT, function (Action $action) {
                return $action
                    ->setCssClass('btn btn-info')
                    ->setIcon('fas fa-edit')->setLabel(false)
                    ->displayIf(fn (Image $image) => $this->security->isGranted(ImageVoter::EDIT, $image));
            })
            ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                return $action
                    ->setCssClass('btn btn-danger')
                    ->setIcon('fas fa-trash-alt')->setLabel(false)
                    ->displayIf(fn (Image $image) => $this->security->isGranted(ImageVoter::EDIT, $image));
            })
        ;
    }
}
