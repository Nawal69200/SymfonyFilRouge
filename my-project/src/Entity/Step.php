<?php

namespace App\Entity;

use App\Repository\StepRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StepRepository::class)]
#[ORM\Table(name: 'step', uniqueConstraints: [
    // Définition d'une contrainte d'unicité sur les colonnes 'recipe_id' et 'step_order'
    // Cela empêche d'avoir deux étapes avec le même ordre (step_order) pour une recette (recipe_id) donnée
    new ORM\UniqueConstraint(columns: ['recipe_id', 'step_order'])
])]
class Step
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $stepOrder = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    // Définition de la relation ManyToOne avec l'entité 'Recipe'
    #[ORM\ManyToOne(inversedBy: 'steps')]
    // Définition de la colonne 'recipe_id' comme clé étrangère pointant vers la colonne 'id' de la table 'recipe'
    // 'nullable: false' indique que cette colonne ne peut pas être nulle (chaque étape doit être associée à une recette)
    #[ORM\JoinColumn(name: 'recipe_id', referencedColumnName: 'id', nullable: false)]

    private ?Recipe $recipe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getStepOrder(): ?int
    {
        return $this->stepOrder;
    }

    public function setStepOrder(int $stepOrder): static
    {
        $this->stepOrder = $stepOrder;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(Recipe $recipe): static
    {
        $this->recipe = $recipe;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getTitle();  
    }
}
