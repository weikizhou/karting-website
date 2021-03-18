<?php

namespace App\Controller\Admin;

use App\Entity\Carousel;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CarouselCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Carousel::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextareaField::new('imageFile')
                ->setFormType(VichImageType::class)
                ->setLabel('Carousel image')
                ->onlyOnForms(),
            ImageField::new('image')
                ->setBasePath('assets/uploads/category/carousel')
                ->hideOnForm()
                ->setLabel('Carousel image'),
        ];
    }

}
