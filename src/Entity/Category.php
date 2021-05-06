<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
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
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @ApiResource(
 *      denormalizationContext={"groups"={"write"}},
 * )
 * @Vich\Uploadable
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var Uuid
     * @ApiProperty(identifier=true)
     * @Groups({"moment"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"moment"})
     */
    private $name;

    /**
     * @ORM\Column(type="time", nullable=true)
     * @Groups({"moment", "write"})
     */
    private $time;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2, nullable=true)
     * @Groups({"moment", "write"})
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=Moment::class, mappedBy="Category")
     *
     */
    private $moments;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"moment", "write"})
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="category_image", fileNameProperty="image")
     * @Groups({"moment", "write"})
     */
    private $imageFile;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"moment", "write"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"moment", "write"})
     */
    private $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"moment", "write"})
     */
    private $introduction;

    /**
     * @ORM\ManyToMany(targetEntity=Carousel::class, inversedBy="categories")
     * @Groups({"moment", "write"})
     */
    private $carousel;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"moment", "write"})
     */
    private $minimumAge;

    public function __construct()
    {
        $this->moments = new ArrayCollection();
        $this->carousel = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(?\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|Moment[]
     */
    public function getMoments(): Collection
    {
        return $this->moments;
    }

    public function addMoment(Moment $moment): self
    {
        if (!$this->moments->contains($moment)) {
            $this->moments[] = $moment;
            $moment->setCategory($this);
        }

        return $this;
    }

    public function removeMoment(Moment $moment): self
    {
        if ($this->moments->removeElement($moment)) {
            // set the owning side to null (unless already changed)
            if ($moment->getCategory() === $this) {
                $moment->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString(){
        if ($this->name != ''){
            return $this->name;
        }
        else{
            return '';
        }
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(?string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }

    /**
     * @return Collection|Carousel[]
     */
    public function getCarousel(): Collection
    {
        return $this->carousel;
    }

    public function addCarousel(Carousel $carousel): self
    {
        if (!$this->carousel->contains($carousel)) {
            $this->carousel[] = $carousel;
        }

        return $this;
    }

    public function removeCarousel(Carousel $carousel): self
    {
        $this->carousel->removeElement($carousel);

        return $this;
    }

    public function getMinimumAge(): ?int
    {
        return $this->minimumAge;
    }

    public function setMinimumAge(?int $minimumAge): self
    {
        $this->minimumAge = $minimumAge;

        return $this;
    }
}
