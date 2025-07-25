<?php

namespace App\Entity;

use App\Repository\DrivingLicenseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DrivingLicenseRepository::class)]
class DrivingLicense
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Category = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Description = null;

    /**
     * @var Collection<int, Driver>
     */
    #[ORM\ManyToMany(targetEntity: Driver::class, mappedBy: 'DrivingLicense')]
    private Collection $drivers;

    public function __construct()
    {
        $this->drivers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->Category;
    }

    public function setCategory(string $Category): static
    {
        $this->Category = $Category;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return Collection<int, Driver>
     */
    public function getDrivers(): Collection
    {
        return $this->drivers;
    }

    public function addDriver(Driver $driver): static
    {
        if (!$this->drivers->contains($driver)) {
            $this->drivers->add($driver);
            $driver->addDrivingLicense($this);
        }

        return $this;
    }

    public function removeDriver(Driver $driver): static
    {
        if ($this->drivers->removeElement($driver)) {
            $driver->removeDrivingLicense($this);
        }

        return $this;
    }
}
