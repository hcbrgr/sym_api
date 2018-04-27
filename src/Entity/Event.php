<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CallSheet", mappedBy="event_id")
     */
    private $callSheets;

    public function __construct()
    {
        $this->callSheets = new ArrayCollection();
    }

    public function getId()
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

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|CallSheet[]
     */
    public function getCallSheets(): Collection
    {
        return $this->callSheets;
    }

    public function addCallSheet(CallSheet $callSheet): self
    {
        if (!$this->callSheets->contains($callSheet)) {
            $this->callSheets[] = $callSheet;
            $callSheet->setEvent($this);
        }

        return $this;
    }

    public function removeCallSheet(CallSheet $callSheet): self
    {
        if ($this->callSheets->contains($callSheet)) {
            $this->callSheets->removeElement($callSheet);
            // set the owning side to null (unless already changed)
            if ($callSheet->getEvent() === $this) {
                $callSheet->setEvent(null);
            }
        }

        return $this;
    }
}
