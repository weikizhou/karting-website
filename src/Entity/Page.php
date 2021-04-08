<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use App\Uuid;

/**
 * @ORM\Entity(repositoryClass=PageRepository::class)
 * @ApiResource()
 * @Vich\Uploadable
 */
class Page implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var Uuid
     * @ApiProperty(identifier=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nav_title;

    /**
     * @ORM\Column(type="boolean")
     */
    private $in_navigation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $introduction_image;

    /**
     * @Vich\UploadableField(mapping="introduction_image", fileNameProperty="introduction_image")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $introduction;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $introduction_title;

    /**
     * @ORM\ManyToMany(targetEntity=Section::class, inversedBy="pages")
     */
    private $section;

    public function __construct()
    {
        $this->section = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getNavTitle(): ?string
    {
        return $this->nav_title;
    }

    public function setNavTitle(?string $nav_title): self
    {
        $this->nav_title = $nav_title;

        return $this;
    }

    public function getInNavigation(): ?bool
    {
        return $this->in_navigation;
    }

    public function setInNavigation(bool $in_navigation): self
    {
        $this->in_navigation = $in_navigation;

        return $this;
    }

    public function getIntroductionImage(): ?string
    {
        return $this->introduction_image;
    }

    public function setIntroductionImage(?string $introduction_image): self
    {
        $this->introduction_image = $introduction_image;

        return $this;
    }


    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

//        if ($image) {
//            $this->updatedAt = new \DateTime('now');
//        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(?string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getIntroductionTitle(): ?string
    {
        return $this->introduction_title;
    }

    public function setIntroductionTitle(?string $introduction_title): self
    {
        $this->introduction_title = $introduction_title;

        return $this;
    }

    /**
     * @return Collection|Section[]
     */
    public function getSection(): Collection
    {
        return $this->section;
    }

    public function addSection(Section $section): self
    {
        if (!$this->section->contains($section)) {
            $this->section[] = $section;
        }

        return $this;
    }

    public function removeSection(Section $section): self
    {
        $this->section->removeElement($section);

        return $this;
    }

    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
        return [
            $this->title => 'title'
        ];
    }
}
