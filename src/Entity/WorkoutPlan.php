<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\WorkoutPlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"workoutplan:read"}},
 *     denormalizationContext={"groups"={"workoutplan:write"}}
 * )
 * @ApiFilter(SearchFilter::class, properties={
 *     "title": "partial",
 *     "description": "partial",
 *     "exercise": "exact",
 *     "exercise.title": "partial"
 * })
 * @ORM\Entity(repositoryClass=WorkoutPlanRepository::class)
 */
class WorkoutPlan
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"workoutplan:read", "workoutplan:write"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"workoutplan:read", "workoutplan:write"})
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Exercise::class)
     * @ApiSubresource()
     */
    private $exercise;

    public function __construct()
    {
        $this->exercise = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Exercise[]
     */
    public function getExercise(): Collection
    {
        return $this->exercise;
    }

    public function addExercise(Exercise $exercise): self
    {
        if (!$this->exercise->contains($exercise)) {
            $this->exercise[] = $exercise;
        }

        return $this;
    }

    public function removeExercise(Exercise $exercise): self
    {
        if ($this->exercise->contains($exercise)) {
            $this->exercise->removeElement($exercise);
        }

        return $this;
    }
}
