<?php

namespace App\Entity;

use App\Repository\DriverRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DriverRepository::class)]
#[UniqueEntity('RegistrationNumber')]
class Driver
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $FirstName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $PhoneNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $RegistrationNumber = null;

    #[ORM\Column]
    private ?bool $Status = null;

    /**
     * @var Collection<int, DrivingLicense>
     */
    #[ORM\ManyToMany(targetEntity: DrivingLicense::class, inversedBy: 'drivers')]
    private Collection $DrivingLicense;

    public function __construct()
    {
        $this->DrivingLicense = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): static
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->PhoneNumber;
    }

    public function setPhoneNumber(?int $PhoneNumber): static
    {
        $this->PhoneNumber = $PhoneNumber;

        return $this;
    }


    public function getRegistrationNumber(): ?string
    {
        return $this->RegistrationNumber;
    }

    public function setRegistrationNumber(string $RegistrationNumber): static
    {
        $this->RegistrationNumber = $RegistrationNumber;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->Status;
    }

    public function setStatus(bool $Status): static
    {
        $this->Status = $Status;

        return $this;
    }

    /**
     * @return Collection<int, DrivingLicense>
     */
    public function getDrivingLicense(): Collection
    {
        return $this->DrivingLicense;
    }

    public function addDrivingLicense(DrivingLicense $drivingLicense): static
    {
        if (!$this->DrivingLicense->contains($drivingLicense)) {
            $this->DrivingLicense->add($drivingLicense);
        }

        return $this;
    }

    public function removeDrivingLicense(DrivingLicense $drivingLicense): static
    {
        $this->DrivingLicense->removeElement($drivingLicense);

        return $this;
    }
}
