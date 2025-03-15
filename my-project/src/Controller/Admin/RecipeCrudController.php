<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class RecipeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recipe::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            ImageField::new('image')
                ->setBasePath('public/images') //indique ou easyadmn recuperer les images
                ->setUploadDir('public/images'), //indique ou easy adminb doit les stocker
            Timefield::new('prepTime')
                ->setLabel('Temps de préparation (HH:MM:SS)'), //remplace le label auto gerer par 1 texte plus clair
            TimeField::new('cookTime')
                ->setLabel('Temps de cuisson (HH:MM:SS)'),
            IntegerField::new('defaultPortions'),
        ];
    }
    
}
