<?php

namespace App\Entity;

use App\Repository\SoortActiviteitenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SoortActiviteitenRepository::class)
 */
class SoortActiviteiten
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $naam;

    /**
     * @ORM\Column(type="integer")
     */
    private $min_leeftijd;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tijdsduur;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2, nullable=true)
     */
    private $prijs;

    /**
     * @ORM\OneToMany(targetEntity=Activiteiten::class, mappedBy="soort")
     */
    private $activiteitens;

    public function __construct()
    {
        $this->activiteitens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNaam(): ?string
    {
        return $this->naam;
    }

    public function setNaam(?string $naam): self
    {
        $this->naam = $naam;

        return $this;
    }

    public function getMinLeeftijd(): ?int
    {
        return $this->min_leeftijd;
    }

    public function setMinLeeftijd(int $min_leeftijd): self
    {
        $this->min_leeftijd = $min_leeftijd;

        return $this;
    }

    public function getTijdsduur(): ?int
    {
        return $this->tijdsduur;
    }

    public function setTijdsduur(?int $tijdsduur): self
    {
        $this->tijdsduur = $tijdsduur;

        return $this;
    }

    public function getPrijs(): ?string
    {
        return $this->prijs;
    }

    public function setPrijs(?string $prijs): self
    {
        $this->prijs = $prijs;

        return $this;
    }

    /**
     * @return Collection|Activiteiten[]
     */
    public function getActiviteitens(): Collection
    {
        return $this->activiteitens;
    }

    public function addActiviteiten(Activiteiten $activiteiten): self
    {
        if (!$this->activiteitens->contains($activiteiten)) {
            $this->activiteitens[] = $activiteiten;
            $activiteiten->setSoort($this);
        }

        return $this;
    }

    public function removeActiviteiten(Activiteiten $activiteiten): self
    {
        if ($this->activiteitens->removeElement($activiteiten)) {
            // set the owning side to null (unless already changed)
            if ($activiteiten->getSoort() === $this) {
                $activiteiten->setSoort(null);
            }
        }

        return $this;
    }
}
