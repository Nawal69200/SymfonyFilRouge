<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RecipeController extends AbstractController
{
    #[Route('/recette', name: 'app_recipe.index')]
    public function index(Request $request, RecipeRepository $repository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER'); // si pas authentifié, pas acces à cette page

        return $this->render('recipe/index.html.twig');
        
    }

    #[Route('/recette/{slug}-{id}', name:'recipe.show', requirements: ['id' => '\d', 'slug' =>'[a-z0-9]+'])]
    public function show(Request $request, string $slug, int $id) 
    {
        return $this->render( 'recipe.show.html.twig', [
            'slug' => $slug,
            'id' => $id
        ]);
    }
}
