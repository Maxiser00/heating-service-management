<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $LicensePlate = null;

    #[ORM\Column(length: 255)]
    private ?string $Brand = null;

    #[ORM\Column(length: 255)]
    private ?string $Model = null;

    #[ORM\OneToMany(mappedBy: 'vehicle', targetEntity: Intervention::class)]
    private Collection $intervention;

    public function __construct()
    {
        $this->intervention = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLicensePlate(): ?string
    {
        return $this->LicensePlate;
    }

    public function setLicensePlate(string $LicensePlate): static
    {
        $this->LicensePlate = $LicensePlate;
        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->Brand;
    }

    public function setBrand(string $Brand): static
    {
        $this->Brand = $Brand;
        return $this;
    }

    public function getModel(): ?string
    {
        return $this->Model;
    }

    public function setModel(?string $Model): void
    {
        $this->Model = $Model;
    }

    public function getIntervention(): Collection
    {
        return $this->intervention;
    }

    public function addIntervention(Intervention $intervention): static
    {
        if (!$this->intervention->contains($intervention)) {
            $this->intervention[] = $intervention;
            $intervention->setVehicle($this);
        }
        return $this;
    }

    public function removeIntervention(Intervention $intervention): static
    {
        if ($this->intervention->removeElement($intervention)) {
            if ($intervention->getVehicle() === $this) {
                $intervention->setVehicle(null);
            }
        }
        return $this;
    }
}
