<?php

namespace App\Entity;

use App\Repository\ActiviteitenRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActiviteitenRepository::class)
 */
class Activiteiten
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=soortactiviteiten::class, inversedBy="activiteitens")
     */
    private $soort;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $datum;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $tijd;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSoort(): ?soortactiviteiten
    {
        return $this->soort;
    }

    public function setSoort(?soortactiviteiten $soort): self
    {
        $this->soort = $soort;

        return $this;
    }

    public function getDatum(): ?\DateTimeInterface
    {
        return $this->datum;
    }

    public function setDatum(?\DateTimeInterface $datum): self
    {
        $this->datum = $datum;

        return $this;
    }

    public function getTijd(): ?\DateTimeInterface
    {
        return $this->tijd;
    }

    public function setTijd(?\DateTimeInterface $tijd): self
    {
        $this->tijd = $tijd;

        return $this;
    }
}
