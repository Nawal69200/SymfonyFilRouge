<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Step;
use App\Repository\StepRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class StepController extends AbstractController
{
    // Route pour la suppression d'une étape
    #[Route('/step/{id}/delete', name: 'delete_step')]
    public function deleteStep(int $id, StepRepository $stepRepository, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'étape à supprimer
        $step = $stepRepository->find($id);

        if (!$step) {
            throw $this->createNotFoundException('Étape non trouvée');
        }

        // Récupérer la recette liée à cette étape
        $recipe = $step->getRecipe();

        // Supprimer l'étape
        $entityManager->remove($step);
        $entityManager->flush();

        // Réorganiser les étapes restantes
        $steps = $stepRepository->findBy(['recipe' => $recipe], ['stepOrder' => 'ASC']);
        $order = 1;
        foreach ($steps as $remainingStep) {
            $remainingStep->setStepOrder($order++); // On met à jour stepOrder, pas `order`
            $entityManager->persist($remainingStep);
        }

        $entityManager->flush();

        // Rediriger vers la page de la recette
        return $this->redirectToRoute('app_recipe_show', ['id' => $recipe->getId()]);
    }

    // Route pour créer une étape
    #[Route('/recipe/{recipeId}/step/create', name: 'create_step')]
    public function createStep(int $recipeId, StepRepository $stepRepository, EntityManagerInterface $entityManager): Response
    {
        // Récupérer la recette par son ID
        $recipe = $entityManager->getRepository(Recipe::class)->find($recipeId);

        if (!$recipe) {
            throw $this->createNotFoundException('Recette non trouvée');
        }

        // Récupérer l'ordre actuel des étapes pour cette recette
        $steps = $stepRepository->findBy(['recipe' => $recipe], ['stepOrder' => 'DESC']);
        $newStepOrder = count($steps) + 1; // L'ordre de la nouvelle étape sera l'ordre maximum + 1

        // Créer une nouvelle étape
        $step = new Step();
        $step->setTitle('Nouvelle étape');
        $step->setContent('Description de la nouvelle étape');
        $step->setStepOrder($newStepOrder);
        $step->setRecipe($recipe); // Associer la recette à l'étape

        // Persister la nouvelle étape
        $entityManager->persist($step);
        $entityManager->flush();

        // Rediriger vers la page de la recette
        return $this->redirectToRoute('app_recipe_show', ['id' => $recipeId]);
    }
}
