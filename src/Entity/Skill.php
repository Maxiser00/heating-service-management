<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Wording = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    #[ORM\ManyToMany(mappedBy: 'skills', targetEntity: Utilisateur::class)]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWording(): ?string
    {
        return $this->Wording;
    }

    public function setWording(string $Wording): static
    {
        $this->Wording = $Wording;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;
        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Utilisateur $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addSkill($this);
        }
        return $this;
    }

    public function removeUser(Utilisateur $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeSkill($this);
        }
        return $this;
    }
}
