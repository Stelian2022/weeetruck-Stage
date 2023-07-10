<?php

namespace App\Controller\Admin;

use App\Entity\Missions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MissionsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Missions::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
