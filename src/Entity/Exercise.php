<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ExerciseRepository;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"exercise:read"}, "swagger_definition_name"="Read"},
 *     denormalizationContext={"groups"={"exercise:write"}, "swagger_definition_name"="Write"},
 *     attributes={
 *         "pagination_items_per_page"=10,
 *         "formats"={"jsonld", "json", "html", "jsonhal", "csv"={"text/csv"}}
 *     }
 * )
 * @ORM\Entity(repositoryClass=ExerciseRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"isFinished"})
 * @ApiFilter(SearchFilter::class, properties={
 *     "title": "partial",
 *     "description": "partial"
 * })
 * @ApiFilter(PropertyFilter::class)
 */
class Exercise
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"exercise:read", "exercise:write", "set:item:get", "set:write"})
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=2,
     *     max=50,
     *     maxMessage="Describe exercise in 50 chars or less"
     * )
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=Set::class, mappedBy="exercise", cascade={"persist"}, orphanRemoval=true)
     * @Groups({"exercise:read", "exercise:write"})
     */
    private $sets;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"exercise:read", "exercise:write"})
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"exercise:read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"exercise:read", "exercise:write"})
     */
    private $isFinished = false;

    public function __construct(string $title)
    {
        $this->sets = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->title = $title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return Collection|Set[]
     */
    public function getSets(): Collection
    {
        return $this->sets;
    }

    public function addSet(Set $set): self
    {
        if (!$this->sets->contains($set)) {
            $this->sets[] = $set;
            $set->setExercise($this);
        }

        return $this;
    }

    public function removeSet(Set $set): self
    {
        if ($this->sets->contains($set)) {
            $this->sets->removeElement($set);
            // set the owning side to null (unless already changed)
            if ($set->getExercise() === $this) {
                $set->setExercise(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Gets description.
     *
     * @Groups({"exercise:read"})
     */
    public function getShortDescription(): ?string
    {
        if (strlen(strip_tags($this->description)) < 40) {
            return $this->description;
        }

        return substr(strip_tags($this->description), 0, 40) . '...';
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Sets description.
     *
     * @Groups({"exercise:write"})
     * @SerializedName("description")
     */
    public function setTextDescription(?string $description): self
    {
        $this->description = nl2br($description);

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * String of created at.
     *
     * @Groups({"exercise:read"})
     */
    public function getCreatedAtAgo(): ?string
    {
        return Carbon::instance($this->getCreatedAt())->diffForHumans();
    }

    public function getIsFinished(): ?bool
    {
        return $this->isFinished;
    }

    public function setIsFinished(bool $isFinished): self
    {
        $this->isFinished = $isFinished;

        return $this;
    }
}
