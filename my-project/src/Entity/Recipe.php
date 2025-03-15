<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $prepTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $cookTime = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: "integer")]
    private ?int $defaultPortions = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    /**
     * @var Collection<int, Step>
     */
    #[ORM\OneToMany(targetEntity: Step::class, mappedBy: 'recipe', cascade: ['persist', 'remove'])]
    private Collection $steps;

    public function __construct()
    {
        $this->steps = new ArrayCollection();
    }

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;
        return $this;
    }

    public function getPrepTime(): ?\DateTimeInterface
    {
        return $this->prepTime;
    }

    public function setPrepTime(\DateTimeInterface $prepTime): static
    {
        $this->prepTime = $prepTime;
        return $this;
    }

    public function getCookTime(): ?\DateTimeInterface
    {
        return $this->cookTime;
    }

    public function setCookTime(?\DateTimeInterface $cookTime): static
    {
        $this->cookTime = $cookTime;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getDefaultPortions(): ?int
    {
        return $this->defaultPortions;
    }

    public function setDefaultPortions(int $defaultPortions): static
    {
        $this->defaultPortions = $defaultPortions;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;
        return $this;
    }
    

    /**
     * @return Collection<int, Step>
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(Step $step): static
    {
        if (!$this->steps->contains($step)) {
            $this->steps->add($step);
            $step->setRecipe($this);
        }

        return $this;
    }

    public function removeStep(Step $step): static
    {
        $this->steps->removeElement($step);
        return $this;
    }

    public function __toString(): string
    {
        return $this->getTitle();  
    }

}
