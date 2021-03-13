<?php

namespace App\Controller\Admin;

use App\Entity\Moment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class MomentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Moment::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('Category'),
            DateField::new('date'),
            TimeField::new('time'),
            IntegerField::new('max_participants'),
        ];
    }

}
