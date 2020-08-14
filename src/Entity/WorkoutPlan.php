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
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     itemOperations={
 *         "get",
 *         "put"={
 *              "access_control"="is_granted('ROLE_USER') and previous_object.getOwner() == user",
 *              "access_control_message"="Only the creator can edit a cheese listing"
 *          },
 *     },
 *     collectionOperations={
 *         "get"={"security"="is_granted('ROLE_USER')"},
 *         "post"={"security"="is_granted('ROLE_USER')"},
 *     },
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
     * @Assert\NotBlank()
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

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="workoutPlans")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ownerWorkoutPlans")
     * @Groups({"workoutplan:read", "workoutplan:write"})
     */
    private $owner;

    public function __construct()
    {
        $this->exercise = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
