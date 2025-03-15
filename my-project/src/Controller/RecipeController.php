<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RecipeController extends AbstractController
{    #[Route('/recette', name: 'app_recipe.index')]
    public function index(Request $request, RecipeRepository $repository, EntityManagerInterface $em, int $id): Response
{

    $this->denyAccessUnlessGranted('ROLE_USER'); // Si pas authentifié, pas accès à cette page
    //$recipes = $repository->findAll();
    //dd($recipes);
    $recipe = new Recipe();
    $em ->remove($recipe[0]);
    $em->flush();  //C'est le flush qui va générer les requêtes

    $recipes = $repository->findRecipeByYserId($id);
    //$recipe->setTitle('Barbe à papa')
       // ->setSlug('barbe-papa')
       // ->setContent('Mettez du sucre')
        //->setCreatedAt(new \DateTimeImmutable())
        //->setUpdatedAt(new \DateTimeImmutable());
        
    $em->persist($recipe);
    $em->flush();
    return $this->render('recipe/index.html.twig', [
        'recipes' => $recipes
    ]);
}

#[Route('/recette/{slug}-{id}', name:'recipe.show', requirements: ['id' => '\d', 'slug' => '[a-z0-9\-]+'])]

    public function show(Request $request, string $slug, int $id, RecipeRepository $repository) 
    {
        $recipe = $repository->find($id);
        if ($recipe->getSlug() !== $slug) {
            return $this->redirectToRoute('recipe.show', ['slug' => $recipe->getSlug(), 'id' => $recipe->getId()]);
        }
        return $this->render( 'recipe.show.html.twig', [
            'recipe' => $recipe
        ]);
    }
}
