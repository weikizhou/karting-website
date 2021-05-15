<?php

namespace App\Entity;

use App\Repository\CarouselRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use App\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=CarouselRepository::class)
 * @ApiResource(
 *     denormalizationContext={"groups"={"write"}},
 * )
 * @Vich\Uploadable
 */
class Carousel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var Uuid
     * @ApiProperty(identifier=true)
     * @Groups({"moment", "write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"moment", "write"})
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="carousel_image", fileNameProperty="image")
     *
     */
    private $imageFile;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, mappedBy="carousel")
     * @Groups({"moment", "write"})
     */
    private $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

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

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addCarousel($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeCarousel($this);
        }

        return $this;
    }

    public function __toString(){
        if ($this->image != ''){
            return $this->image;
        }
        else{
            return '';
        }
    }
}
