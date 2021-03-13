<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CarouselType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            SlugField::new('slug')
                ->setTargetFieldName('name')
                ->onlyOnForms(),
            TimeField::new('time'),
            MoneyField::new('price')->setCurrency('EUR'),
            NumberField::new('minimum_age'),

            TextareaField::new('imageFile')
                ->setFormType(VichImageType::class)
                ->setLabel('Category image')
                ->onlyOnForms(),
            ImageField::new('image')->setBasePath('assets/uploads/category')->hideOnForm(),

            TextEditorField::new('introduction'),
            TextEditorField::new('description'),
//            CollectionField::new('carousel')
//                ->setFormType(CarouselType::class)
        ];
    }

}
