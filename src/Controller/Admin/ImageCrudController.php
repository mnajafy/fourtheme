<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Form\ImageType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ImageCrudController extends AbstractCrudController
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
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
            DateTimeField::new('createdAt')->onlyOnDetail(),
            DateTimeField::new('UpdatedAt')->onlyOnDetail(),
            Field::new('imageFile', 'Image')
                ->onlyOnForms()
                ->setFormType(VichFileType::class)
            ,
            ImageField::new('image')
                ->hideOnForm()
                ->setBasePath($this->params->get('app.path.uploads_images'))
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
