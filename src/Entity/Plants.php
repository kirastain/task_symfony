<?php

namespace App\Entity;

use App\Repository\PlantsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlantsRepository::class)
 */
class Plants
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\Column(type="float")
     */
    private $capacity;

    /**
     * @ORM\ManyToMany(targetEntity=Owners::class, mappedBy="plants")
     */
    private $owners;

    public function __construct()
    {
        $this->owners = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getCapacity(): ?float
    {
        return $this->capacity;
    }

    public function setCapacity(float $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * @return Collection|Owners[]
     */
    public function getOwners(): Collection
    {
        return $this->owners;
    }

    public function addOwner(Owners $owner): self
    {
        if (!$this->owners->contains($owner)) {
            $this->owners[] = $owner;
            $owner->addPlant($this);
        }

        return $this;
    }

    public function removeOwner(Owners $owner): self
    {
        if ($this->owners->contains($owner)) {
            $this->owners->removeElement($owner);
            $owner->removePlant($this);
        }

        return $this;
    }
}