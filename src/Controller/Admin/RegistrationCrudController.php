<?php

namespace App\Controller\Admin;

use App\Entity\Registration;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class RegistrationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Registration::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('moment'),
            AssociationField::new('user'),
            DateField::new('created_at'),
        ];
    }

}
