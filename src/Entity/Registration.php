<?php

namespace App\Entity;

use App\Repository\RegistrationRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use App\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\SerializedName;


/**
 * @ORM\Entity(repositoryClass=RegistrationRepository::class)
 * @ApiResource(
 *      collectionOperations={"get", "post"},
 *      itemOperations={"get", "put", "delete"},
 *      normalizationContext={"groups"={"read"}},
 *      denormalizationContext={"groups"={"write"}},
 *      attributes={"fetchEager": true}
 * )
 */
class Registration
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var Uuid
     * @ApiProperty(identifier=true)
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Moment::class, inversedBy="registrations")
     * @Groups({"read", "write"})
     *
     */
    private $moment;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="registrations")
     * @Groups({"read", "write"})
     *
     */
    private $user;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"read", "write"})
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMoment(): ?Moment
    {
        return $this->moment;
    }

    public function setMoment(?Moment $moment): self
    {
        $this->moment = $moment;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

}
