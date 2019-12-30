<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=35)
     * @Assert\Length(
     *     min=5,
     *     max=35,
     *     minMessage="The title must be more than 4 characters.",
     *     maxMessage="The title must be less than 36 characters."
     * )
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=35)
     * @Assert\Length(
     *     min=5,
     *     max=35,
     *     minMessage="The category must be more than 4 characters.",
     *     maxMessage="The category must be less than 36 characters."
     * )
     * @Assert\NotBlank()
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\Length(
     *     min=5,
     *     max=60,
     *     minMessage="The description must be more than 4 characters.",
     *     maxMessage="The description must be less than 61 characters."
     * )
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=6)
     * @Assert\Length(
     *     min=4,
     *     max=6,
     *     minMessage="The date must be more than 3 characters (example : 2019 = 4 characters).",
     *     maxMessage="The date must be less than 7 characters (example : [2019] = 6 characters)."
     * )
     * @Assert\NotBlank()
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Picture", mappedBy="project", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $pictures;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
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

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|Picture[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setProject($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->contains($picture)) {
            $this->pictures->removeElement($picture);
        }

        return $this;
    }
}
