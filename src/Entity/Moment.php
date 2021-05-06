<?php

namespace App\Entity;

use App\Repository\MomentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use App\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;

/**
 * @ORM\Entity(repositoryClass=MomentRepository::class)
 * @ApiFilter(RangeFilter::class, properties={"date"})
 * @ApiResource(
 *     normalizationContext={"groups": {"moment"}}),
 *     denormalizationContext={"groups"={"write"}},
 * )
 *
 */
class Moment
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
     * @ORM\Column(type="time", nullable=true)
     * @Groups({"moment", "write"})
     */
    private $time;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"moment", "write"})
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="moments", fetch="EAGER")
     * @Groups({"moment", "write"})
     *
     */
    private $Category;

    /**
     * @ORM\OneToMany(targetEntity=Registration::class, mappedBy="moment")
     * @Groups({"moment"})
     */
    private $registrations;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"moment", "write"})
     */
    private $maxParticipants;

    public function __construct()
    {
        $this->registrations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): self
    {
        $this->Category = $Category;

        return $this;
    }

    /**
     * @return Collection|Registration[]
     */
    public function getRegistrations(): Collection
    {
        return $this->registrations;
    }

    public function addRegistration(Registration $registration): self
    {
        if (!$this->registrations->contains($registration)) {
            $this->registrations[] = $registration;
            $registration->setMoment($this);
        }

        return $this;
    }

    public function removeRegistration(Registration $registration): self
    {
        if ($this->registrations->removeElement($registration)) {
            // set the owning side to null (unless already changed)
            if ($registration->getMoment() === $this) {
                $registration->setMoment(null);
            }
        }

        return $this;
    }

    public function getMaxParticipants(): ?int
    {
        return $this->maxParticipants;
    }

    public function setMaxParticipants(?int $maxParticipants): self
    {
        $this->maxParticipants = $maxParticipants;

        return $this;
    }

}
