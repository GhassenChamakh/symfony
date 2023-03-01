<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nsc = null;

    #[ORM\Column(length: 50)]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: Classroom::class)]
    private Collection $Classroom;

    public function __construct()
    {
        $this->Classroom = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNsc(): ?int
    {
        return $this->nsc;
    }

    public function setNsc(int $nsc): self
    {
        $this->nsc = $nsc;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Classroom>
     */
    public function getClassroom(): Collection
    {
        return $this->Classroom;
    }

    public function addClassroom(Classroom $classroom): self
    {
        if (!$this->Classroom->contains($classroom)) {
            $this->Classroom->add($classroom);
            $classroom->setStudent($this);
        }

        return $this;
    }

    public function removeClassroom(Classroom $classroom): self
    {
        if ($this->Classroom->removeElement($classroom)) {
            // set the owning side to null (unless already changed)
            if ($classroom->getStudent() === $this) {
                $classroom->setStudent(null);
            }
        }

        return $this;
    }
}
